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
            'total'      => $product->price,
            'notes'      => $request->notes,
            'status'     => 'pendiente', // estado inicial
        ]);

        // Actualizar total de la orden
        $this->updateOrderTotal($order);

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
            'total'      => $product->price,
            'notes'      => $request->notes,
            'status'     => $request->status,
        ]);

        // Actualizar total de la orden
        $this->updateOrderTotal($orderItem->order);

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

        // Actualizar total de la orden
        $this->updateOrderTotal($order);

        return redirect()->route('orders.edit', $order->id)
                         ->with('success', '✅ Producto eliminado de la orden.');
    }

    /**
     * 🔹 Actualiza el total de la orden sumando todos sus items.
     */
    protected function updateOrderTotal(Order $order)
    {
        $total = $order->order_items()->sum('total');
        $order->update(['total_amount' => $total]);
    }
}
