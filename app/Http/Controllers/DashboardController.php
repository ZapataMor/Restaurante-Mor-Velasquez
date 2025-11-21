<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ============================
        // 📌 Estadísticas globales
        // ============================
        $stats = [
            'orders_today'       => Order::whereDate('created_at', today())->count(),
            'sales_today'        => Invoice::where('status', 'Pagada')
                                           ->whereDate('created_at', today())
                                           ->sum('total'),
            'reservations_today' => Reservation::whereDate('reservation_time', today())->count(),
            'tables_occupied'    => Table::where('status', 'Ocupada')->count(),
            'completed_today'    => Order::whereDate('updated_at', today())
                                        ->where('status', 'completada')
                                        ->count(),
            'pending_orders'     => Order::whereIn('status', ['abierta','en_proceso'])
                                        ->count(),
        ];

        // ============================
        // 📌 Datos comunes
        // ============================
        $activeOrders = Order::whereIn('status', ['abierta', 'en_proceso'])
            ->with(['table', 'user', 'orderItems.product'])
            ->latest()
            ->get();

        $upcomingReservations = Reservation::where('status', 'confirmada')
            ->where('reservation_time', '>', now()->endOfDay())  // después de hoy
            ->orderBy('reservation_time', 'asc')
            ->get();

        $todayReservations = Reservation::where('status', 'confirmada')
            ->whereDate('reservation_time', Carbon::today())
            ->whereTime('reservation_time', '>=', now()->format('H:i:s'))
            ->orderBy('reservation_time', 'asc')
            ->get();



        $pendingReservations = Reservation::where('status', 'pendiente')
            ->orderBy('reservation_time', 'asc')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->select('products.name', DB::raw('COUNT(order_items.product_id) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

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

        $cancelledReservations = Reservation::where('status', 'cancelada')
            ->where('reservation_time', '>=', Carbon::today()) // hoy o futura
            ->orderBy('reservation_time', 'asc') // las más cercanas primero
            ->get();

        // ============================
        // 📌 Vistas por ROL
        // ============================

        switch ($user->role) {

            case 'mesero':
                $myOrders = Order::where('user_id', $user->id)
                    ->whereIn('status', ['abierta', 'en_proceso'])
                    ->with(['table', 'orderItems.product'])
                    ->latest()
                    ->get();

                $reservation = Reservation::whereDate('reservation_time', today())
                    ->orderBy('reservation_time')
                    ->first();

                $tables = Table::all();

                return view('dashboard.mesero.index', compact(
                    'stats',
                    'myOrders',
                    'activeOrders',
                    'reservation',
                    'tables'
                ));

            case 'recepcionista':
                // Aquí ves solo reservas + mesas
                return view('dashboard.recepcionista.index', compact(
                    'stats',
                    'upcomingReservations',
                    'pendingReservations',
                    'activeOrders',
                    'todayReservations',
                    'cancelledReservations'
                ));

            case 'chef':
                // Traemos todas las órdenes abiertas o en proceso
                $chefOrders = Order::whereIn('status', ['abierta', 'en_proceso'])
                    ->with(['table', 'orderItems.product'])
                    ->latest()
                    ->get();

                // Estadísticas rápidas basadas en items de las órdenes
                $stats = [
                    'total_items'      => $chefOrders->sum(fn($order) => $order->orderItems->count()),
                    'pending_items'    => $chefOrders->sum(fn($order) => $order->orderItems->where('status', 'pendiente')->count()),
                    'preparing_items'  => $chefOrders->sum(fn($order) => $order->orderItems->where('status', 'preparando')->count()),
                    'ready_today'      => OrderItem::where('status', 'listo')
                                                ->whereDate('updated_at', today())
                                                ->count(),
                ];

                return view('dashboard.chef.index', compact('chefOrders', 'stats'));



            case 'admin':
            default:
                return view('dashboard.admin.index', compact(
                    'stats',
                    'activeOrders',
                    'upcomingReservations',
                    'topProducts',
                    'salesByDay'
                ));
        }
    }
}
