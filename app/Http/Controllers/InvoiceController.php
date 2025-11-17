<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * 🟡 Mostrar todas las facturas.
     */
    public function index()
    {
        $invoices = Invoice::with(['order', 'generatedBy'])->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * 🟢 Mostrar formulario para crear una factura a partir de una orden.
     */
    public function create(Order $order)
    {
        return view('invoices.create', compact('order'));
    }

    /**
     * 🔵 Guardar una factura.
     */
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'client_name'    => 'required|string|max:255',
            'client_document'=> 'required|string|max:50',
            'discount'       => 'nullable|numeric|min:0',
            'tax'            => 'nullable|numeric|min:0',
            'payment_method' => ['required', Rule::in(['Efectivo','Tarjeta','Transferencia','Mixto'])],
        ]);

        $subtotal = $order->total_amount;       // Total de la orden
        $tax      = $request->tax ?? 0;         // Impuestos
        $discount = $request->discount ?? 0;    // Descuentos
        $total    = $subtotal + $tax - $discount;

        $invoice = Invoice::create([
            'order_id'       => $order->id,
            'client_name'    => $request->client_name,
            'client_document'=> $request->client_document,
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'discount'       => $discount,
            'total'          => $total,
            'payment_method' => $request->payment_method,
            'status'         => 'Pendiente',
            'generated_by'   => Auth::id(),
        ]);

        return redirect()->route('invoices.show', $invoice->id)
                        ->with('success', '✅ Factura generada correctamente.');
    }

    /**
     * 🟣 Mostrar una factura específica.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['order.order_items.product', 'order.table', 'generatedBy']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * 🔵 Actualizar estado de la factura (pagada, anulada, pendiente).
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => ['required', Rule::in(['Pagada','Anulada','Pendiente'])]
        ]);

        $invoice->update([
            'status' => $request->status
        ]);

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', '✅ Estado de la factura actualizado.');
    }

    /**
     * 🔴 Eliminar una factura.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
                         ->with('success', '✅ Factura eliminada correctamente.');
    }
}
