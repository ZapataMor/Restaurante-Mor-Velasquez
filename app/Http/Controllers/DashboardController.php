<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Product;
use Illuminate\Http\Request;

// IMPORTANTE
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // <- ya funciona

        // Estadísticas principales
        $stats = [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'sales_today' => Invoice::where('status', 'Pagada')
                                    ->whereDate('created_at', today())
                                    ->sum('total'),
            'reservations_today' => Reservation::whereDate('reservation_time', today())->count(),
            'tables_occupied' => Table::where('status', 'Ocupada')->count(),
        ];

        // Órdenes activas
        $activeOrders = Order::whereIn('status', ['Pendiente', 'En Proceso'])
            ->with(['table', 'user', 'orderItems.product'])
            ->latest()
            ->get();

        // Reservas próximas
        $upcomingReservations = Reservation::where('reservation_time', '>=', now())
            ->orderBy('reservation_time')
            ->take(5)
            ->get();

        // Productos más vendidos
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->select('products.name', DB::raw('COUNT(order_items.product_id) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Ventas por día
        $salesByDay = Invoice::where('status', 'Pagada')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Si es mesero = solo ve sus órdenes
        if ($user->role === 'waiter') {
            $myOrders = Order::where('waiter_id', $user->id)
                ->whereIn('status', ['Pendiente', 'En Proceso'])
                ->with(['table', 'orderItems.product'])
                ->latest()
                ->get();

            return view('dashboard.waiter', compact('stats', 'myOrders', 'activeOrders'));
        }

        // Si es admin
        return view('dashboard.admin', compact(
            'stats',
            'activeOrders',
            'upcomingReservations',
            'topProducts',
            'salesByDay'
        ));
    }
}
