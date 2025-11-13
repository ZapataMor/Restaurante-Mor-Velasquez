<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['table', 'customer', 'waiter', 'orderItems.product']);

        // Filtros
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $orders = $query->latest()->paginate(20);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $tables = Table::available()->get();
        $products = Product::available()->with('recipes.ingredient')->get();
        $customers = Customer::latest()->take(50)->get();

        return view('orders.create', compact('tables', 'products', 'customers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table_id' => 'required|exists:tables,table_id',
            'customer_id' => 'nullable|exists:customers,customer_id',
            'type' => 'required|in:Normal,Extra',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'table_id' => $request->table_id,
                'customer_id' => $request->customer_id,
                'waiter_id' => Auth::id(),
                'type' => $request->type,
                'status' => 'En Vista',
            ]);

            // Crear items de la orden
            foreach ($request->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                    'status' => 'Pendiente',
                ]);
            }

            // Actualizar estado de la mesa
            $table = Table::find($request->table_id);
            $table->status = 'Ocupada';
            $table->save();

            DB::commit();

            return redirect()->route('orders.show', $order->order_id)
                ->with('success', 'Orden creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la orden: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(['table', 'customer', 'waiter', 'orderItems.product', 'invoice']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        if (in_array($order->status, ['Pagada', 'Entregada'])) {
            return redirect()->back()
                ->with('error', 'No se puede editar una orden finalizada');
        }

        $order->load('orderItems.product');
        $products = Product::available()->get();

        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        if (in_array($order->status, ['Pagada', 'Entregada'])) {
            return redirect()->back()
                ->with('error', 'No se puede editar una orden finalizada');
        }

        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Eliminar items anteriores que no estaban listos
            $order->orderItems()->where('status', '!=', 'Listo')->delete();

            // Agregar nuevos items
            foreach ($request->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                    'status' => 'Pendiente',
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order->order_id)
                ->with('success', 'Orden actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar la orden: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Cambiar estado de la orden
    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:En Vista,Confirmada,En Preparación,Lista,Entregada,Pagada',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $order->status = $request->status;
        $order->save();

        // Si la orden está confirmada, actualizar items a "En Preparación"
        if ($request->status === 'Confirmada') {
            $order->orderItems()->where('status', 'Pendiente')->update(['status' => 'En Preparación']);
        }

        return redirect()->back()
            ->with('success', 'Estado de orden actualizado');
    }

    public function destroy(Order $order)
    {
        if ($order->status !== 'En Vista') {
            return redirect()->back()
                ->with('error', 'Solo se pueden eliminar órdenes en estado "En Vista"');
        }

        DB::beginTransaction();
        try {
            // Liberar mesa
            $order->table->status = 'Disponible';
            $order->table->save();

            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Orden eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la orden');
        }
    }

    // Vista de cocina
    public function kitchen()
    {
        $orders = Order::whereIn('status', ['Confirmada', 'En Preparación'])
            ->with(['table', 'orderItems' => function($q) {
                $q->whereIn('status', ['Pendiente', 'En Preparación'])
                  ->with('product');
            }])
            ->get();

        return view('orders.kitchen', compact('orders'));
    }

    // Actualizar estado de item individual
    public function updateItemStatus(Request $request, OrderItem $item)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pendiente,En Preparación,Listo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Estado inválido'], 400);
        }

        $item->status = $request->status;
        $item->save();

        // Verificar si todos los items están listos
        $order = $item->order;
        $allReady = $order->orderItems()->where('status', '!=', 'Listo')->count() === 0;
        
        if ($allReady && $order->status === 'En Preparación') {
            $order->status = 'Lista';
            $order->save();
        }

        return response()->json(['success' => true, 'order_status' => $order->status]);
    }
}

