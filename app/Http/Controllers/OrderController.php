<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * 🟡 Mostrar todas las órdenes.
     */
    public function index()
    {
        return redirect()->route('tables.map');
    }

    /**
     * 🟢 Mostrar formulario para crear una nueva orden.
     */
    public function create(Request $request)
    {
        $tables       = Table::all();
        $reservations = Reservation::all();
        $meseros      = User::where('role', 'mesero')->get();
        $productos    = Product::all();

        // Capturamos el table_id si viene en la URL
        $selectedTableId = $request->query('table_id');

        return view('orders.create', compact(
            'tables', 'reservations', 'meseros', 'productos', 'selectedTableId'
        ));
    }


    /**
     * 🔵 Guardar una nueva orden en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'nullable|exists:reservations,id',
            'table_id'       => 'required|exists:tables,id',
            'user_id'        => 'required|exists:users,id',
            'status'         => ['required', Rule::in(['abierta','en_proceso','completada','cancelada'])],
            'payment_status' => ['required', Rule::in(['pendiente','pagado'])],
        ]);

        // Validar que el usuario asignado sea mesero
        $mesero = User::find($request->user_id);
        if ($mesero->role !== 'mesero') {
            return redirect()->back()->with('error', '❌ Solo los meseros pueden atender una orden.');
        }

        $order = Order::create([
            'reservation_id' => $request->reservation_id,
            'table_id'       => $request->table_id,
            'user_id'        => $request->user_id,
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
            'total_amount'   => 0, // Inicialmente cero, se calcula al agregar items
        ]);

        return redirect()->route('orders.edit', $order->id)
                         ->with('success', '✅ Orden creada correctamente. Ahora agrega los productos.');
    }

    /**
     * 🟣 Mostrar una orden específica con sus items.
     */
    public function show(Order $order)
    {
        $order->load(['reservation', 'table', 'user', 'orderItems.product']);
        return view('orders.show', compact('order'));
    }

    /**
     * 🔵 Mostrar formulario para editar una orden.
     */
    public function edit(Order $order)
    {
        $tables       = Table::all();
        $reservations = Reservation::all();
        $meseros      = User::where('role', 'mesero')->get();
        $order->load('orderItems.product');

        return view('orders.edit', compact('order', 'tables', 'reservations', 'meseros'));
    }

    /**
     * 🟢 Actualizar una orden.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'reservation_id'   => 'nullable|exists:reservations,id',
            'table_id'         => 'required|exists:tables,id',
            'user_id'          => 'required|exists:users,id',
            'status'           => ['required', Rule::in(['abierta','en_proceso','completada','cancelada'])],
            'payment_status'   => ['required', Rule::in(['pendiente','pagado'])],
            'client_name'      => 'nullable|string|max:255',
            'client_document'  => 'nullable|string|max:255',
        ]);

        // Validar que el usuario asignado sea mesero
        $mesero = User::find($request->user_id);
        if ($mesero->role !== 'mesero') {
            return redirect()->back()->with('error', '❌ Solo los meseros pueden atender una orden.');
        }

        $order->update([
            'reservation_id'   => $request->reservation_id,
            'table_id'         => $request->table_id,
            'user_id'          => $request->user_id,
            'status'           => $request->status,
            'payment_status'   => $request->payment_status,
            'client_name'      => $request->client_name,
            'client_document'  => $request->client_document,
        ]);



        $statusMap = [
            'Pendiente'       => 'pendiente',
            'En Preparación'  => 'preparando',
            'Listo'           => 'listo',
        ];

        foreach ($request->items as $itemId => $data) {
            $orderItem = $order->orderItems()->find($itemId);
            if ($orderItem) {
                $orderItem->update([
                    'quantity' => $data['quantity'],
                    'notes'    => $data['notes'],
                    'status'   => $statusMap[$data['status']] ?? $orderItem->status,
                    'total'    => $orderItem->price * $data['quantity'],
                ]);
            }
        }




        return redirect()->route('orders.show', $order->id)
                         ->with('success', '✅ Orden actualizada correctamente.');
    }

    /**
     * 🔴 Eliminar una orden.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
                         ->with('success', '✅ Orden eliminada correctamente.');
    }

    /**
     * 🟢 Cerrar una orden (completarla y liberar la mesa)
     */
    public function close(Order $order)
    {
        if ($order->status === 'completada') {
            return redirect()->back()->with('info', '⚠️ Esta orden ya está completada.');
        }

        $order->update([
            'status' => 'completada',
            'payment_status' => 'pagado',
        ]);

        return redirect()->route('tables.map', $order->id)
                        ->with('success', '✅ La orden ha sido completada y la mesa liberada.');
    }

}
