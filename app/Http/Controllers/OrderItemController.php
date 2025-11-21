<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemController extends Controller
{
    /**
     * 🟡 Mostrar formulario para agregar un item a la orden.
     */
    public function create(Order $order)
    {
        $products = Product::where('status', 'Activo')->get(); // Solo productos activos
        return view('order_items.create', compact('order', 'products'));
    }

    /**
     * 🟢 Guardar un nuevo item en la orden.
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'notes'      => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        $orderItem = OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'price'      => $product->price,
            'total'      => $product->price, // Mantener la lógica que ya tenías
            'notes'      => $request->notes,
            'status'     => 'pendiente', // estado inicial
        ]);

        // Llamar al método del modelo para recalcular el total (excluye items cancelados)
        $order->calculateTotal();

        return redirect()->route('orders.edit', $order->id)
                         ->with('success', '✅ Producto agregado a la orden.');
    }

    /**
     * 🟣 Mostrar formulario para editar un item de la orden.
     */
    public function edit(OrderItem $orderItem)
    {
        $products = Product::where('status', 'Activo')->get();
        $order = $orderItem->order;
        return view('order_items.edit', compact('orderItem', 'products', 'order'));
    }

    /**
     * 🔵 Actualizar un item de la orden.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'notes'      => 'nullable|string',
            'status'     => ['required', 'in:pendiente,preparando,listo,servido,cancelado'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $orderItem->update([
            'product_id' => $product->id,
            'price'      => $product->price,
            'total'      => $product->price, // Mantener la lógica actual (si quieres multiplicar por qty, ajusta aquí)
            'notes'      => $request->notes,
            'status'     => $request->status,
        ]);

        // Llamar al método del modelo para recalcular el total
        $orderItem->order->calculateTotal();

        return redirect()->route('orders.edit', $orderItem->order->id)
                         ->with('success', '✅ Producto de la orden actualizado.');
    }

    /**
     * 🔴 Eliminar un item de la orden.
     */
    public function destroy(OrderItem $orderItem)
    {
        $order = $orderItem->order;
        $orderItem->delete();

        // Llamar al método del modelo para recalcular el total
        $order->calculateTotal();

        return redirect()->route('orders.edit', $order->id)
                         ->with('success', '✅ Producto eliminado de la orden.');
    }

    /**
     * 🔹 (Wrapper opcional) Actualiza el total de la orden usando el método del modelo.
     *       No es estrictamente necesario si llamas directamente a calculateTotal(),
     *       pero lo dejo como helper por compatibilidad.
     */
    protected function updateOrderTotal(Order $order)
    {
        $order->calculateTotal();
    }
}
