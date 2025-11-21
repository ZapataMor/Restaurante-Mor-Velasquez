<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
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
        $tables = Table::all();
        $productos = Product::all();
        $selectedTableId = $request->query('table_id');

        $reservation = null;

        if ($selectedTableId) {
            // Buscar reserva confirmada para hoy
            $reservation = Reservation::where('table_id', $selectedTableId)
                ->where('status', 'confirmada')
                ->whereDate('reservation_time', now()->toDateString())
                ->first();

            // Solo llenar cliente si no hay orden activa
            if ($reservation && $reservation->table->hasActiveOrder($reservation)) {
                $reservation = null;
            }
        }
        return view('orders.create', compact('tables', 'productos', 'selectedTableId', 'reservation'));
    }

    /**
     * 🔵 Guardar una nueva orden en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'table_id'           => 'required|exists:tables,id',
            'type'               => 'required|string',
            'client_name'        => 'required|string',
            'client_document'    => 'required|string',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.notes'      => 'nullable|string',
        ]);

        // Validar rol del usuario
        $mesero = User::find($request->user_id);
        if ($mesero->role !== 'mesero') {
            return redirect()->back()->with('error', '❌ Solo los meseros pueden atender una orden.');
        }

        // Crear orden base
        $order = Order::create([
            'reservation_id'  => $request->reservation_id,
            'table_id'        => $request->table_id,
            'user_id'         => $request->user_id,
            'status'          => $request->status,
            'payment_status'  => $request->payment_status,
            'total_amount'    => 0,
            'client_name'     => $request->client_name,
            'client_document' => $request->client_document,
        ]);

        // Para acumular total de la orden (temporal)
        $totalOrder = 0;

        // Guardar cada item
        foreach ($request->items as $item) {
            // Obtener el producto
            $product = Product::findOrFail($item['product_id']);

            // Calcular total del item
            $lineTotal = $product->price * $item['quantity'];

            // Acumular total general
            $totalOrder += $lineTotal;

            // Guardar item con su total
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $product->price,
                'notes'      => $item['notes'] ?? null,
                'total'      => $lineTotal,
                'status'     => 'pendiente',
            ]);
        }

        // Actualizar el total de la orden (valor provisional)
        $order->update(['total_amount' => $totalOrder]);

        // >>> Llamada al método del modelo para recalcular el total respetando la lógica
        // (por ejemplo: excluir items con status = 'cancelado')
        $order->calculateTotal();

        // Cambiar estado de la mesa a 'Ocupada'
        $table = Table::find($request->table_id);
        if ($table) {
            $table->status = 'Ocupada';
            $table->save();
        }

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', '✅ Orden creada correctamente.');
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

        // Cargar relaciones necesarias
        $order->load('orderItems.product');

        // 🔥 Asegúrate de que esta línea esté presente
        $productos = Product::select('id', 'name', 'price')->get();

        return view('orders.edit', compact('order', 'tables', 'reservations', 'meseros', 'productos'));
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

        // Validar mesero
        $mesero = User::find($request->user_id);
        if ($mesero->role !== 'mesero') {
            return back()->with('error', '❌ Solo los meseros pueden atender una orden.');
        }

        // Actualizar orden
        $order->update([
            'reservation_id'   => $request->reservation_id,
            'table_id'         => $request->table_id,
            'user_id'          => $request->user_id,
            'status'           => $request->status,
            'payment_status'   => $request->payment_status,
            'client_name'      => $request->client_name,
            'client_document'  => $request->client_document,
        ]);

        // 🔥 ACTUALIZAR ITEMS
        $totalOrder = 0;

        // Aseguramos que $request->items exista para evitar errores si no se envía
        $items = $request->input('items', []);

        foreach ($items as $itemKey => $data) {
            // 🔑 Diferenciar entre items nuevos y existentes
            // Si el key empieza con "new_", es un item nuevo
            if (str_starts_with($itemKey, 'new_')) {
                // 🟢 Item nuevo → se crea
                $product = Product::findOrFail($data['product_id']);
                $lineTotal = $product->price * ($data['quantity'] ?? 1);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $data['product_id'],
                    'quantity'   => $data['quantity'],
                    'price'      => $product->price,
                    'notes'      => $data['notes'] ?? null,
                    'status'     => $data['status'] ?? 'pendiente',
                    'total'      => $lineTotal,
                ]);
                $totalOrder += $lineTotal;
            } else {
                // 🔵 Item existente → se actualiza
                $orderItem = OrderItem::find($itemKey);

                if ($orderItem && $orderItem->order_id == $order->id) {
                    $product = Product::findOrFail($data['product_id']);
                    $lineTotal = $product->price * ($data['quantity'] ?? $orderItem->quantity);

                    $orderItem->update([
                        'product_id' => $data['product_id'],
                        'quantity'   => $data['quantity'],
                        'price'      => $product->price,
                        'notes'      => $data['notes'] ?? null,
                        'status'     => $data['status'] ?? $orderItem->status,
                        'total'      => $lineTotal,
                    ]);

                    $totalOrder += $lineTotal;
                }
            }
        }

        // 🔥 Actualizar total provisional de la orden (por compatibilidad)
        $order->update(['total_amount' => $totalOrder]);
        // >>> Llamada al método del modelo para recalcular el total definitivo
        // (esto asegurará que items con status = 'cancelado' no se incluyan)
        $order->calculateTotal();

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

        // Asegurar total actualizado antes de cerrar
        $order->calculateTotal();
        
        $order->update([
            'status' => 'completada',
            'payment_status' => 'pagado',
        ]);

        // 🔥 IMPORTANTE: Marcar la reserva como completada
        if ($order->reservation_id) {
            $reservation = Reservation::find($order->reservation_id);
            if ($reservation && $reservation->status === 'confirmada') {
                $reservation->update(['status' => 'completada']);
            }
        }
        
        // 🔥 ALTERNATIVA: Si no hay reservation_id pero la mesa tiene una reserva confirmada
        if (!$order->reservation_id && $order->table_id) {
            $table = Table::find($order->table_id);
            if ($table) {
                $activeReservation = $table->activeReservation();
                if ($activeReservation) {
                    $activeReservation->update(['status' => 'completada']);
                }
            }
        }

        return redirect()
            ->route('tables.map')
            ->with('success', '✅ La orden ha sido completada y la mesa liberada.');
    }

    /**
     * Actualizar solo el estado de la orden
     */
    public function updateStatus(Request $request, Order $order)
    {
        $order->load('orderItems');

        if ($request->input('status') === 'completada') {
            // Verificar que todos los items estén listos o cancelados
            $allReady = $order->orderItems->every(function ($item) {
                return in_array($item->status, ['listo', 'cancelado']);
            });

            if ($allReady) {
                $order->status = 'completada';
                $order->payment_status = 'pagado';
                $order->save();

                // 🔥 Marcar la reserva asociada como completada
                if ($order->reservation_id) {
                    $reservation = Reservation::find($order->reservation_id);
                    if ($reservation && $reservation->status === 'confirmada') {
                        $reservation->update(['status' => 'completada']);
                    }
                }
                
                // 🔥 ALTERNATIVA: Si no hay reservation_id pero la mesa tiene una reserva confirmada
                if (!$order->reservation_id && $order->table_id) {
                    $table = Table::find($order->table_id);
                    if ($table) {
                        $activeReservation = $table->activeReservation();
                        if ($activeReservation) {
                            $activeReservation->update(['status' => 'completada']);
                        }
                    }
                }

                return redirect()->back()->with('success', '✅ Orden completada y mesa liberada.');
            }

            return redirect()->back()->with('error', '❌ No se puede completar: algunos items no están listos.');
        }

        return redirect()->back();
    }
}
