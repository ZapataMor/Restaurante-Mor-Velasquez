<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Estadísticas generales
        $stats = [
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'sales_today' => Invoice::paid()->whereDate('created_at', today())->sum('total'),
            'reservations_today' => Reservation::today()->count(),
            'tables_occupied' => Table::occupied()->count(),
            'low_stock_ingredients' => Ingredient::lowStock()->count(),
        ];

        // Órdenes activas
        $activeOrders = Order::inProgress()
            ->with(['table', 'customer', 'waiter', 'orderItems.product'])
            ->latest()
            ->take(10)
            ->get();

        // Reservaciones próximas
        $upcomingReservations = Reservation::confirmed()
            ->where('reservation_date', '>=', now())
            ->where('reservation_date', '<=', now()->addDays(7))
            ->with(['customer', 'table'])
            ->orderBy('reservation_date')
            ->take(5)
            ->get();

        // Ingredientes con stock bajo
        $lowStockIngredients = Ingredient::lowStock()
            ->with('recipes.product')
            ->take(5)
            ->get();

        // Productos más vendidos (últimos 30 días)
        $topProducts = \DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.created_at', '>=', now()->subDays(30))
            ->select('products.name', \DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.product_id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Ventas por día (últimos 7 días)
        $salesByDay = Invoice::paid()
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('SUM(total) as total'),
                \DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Dashboard específico por rol
        if ($user->isWaiter()) {
            $myOrders = Order::where('waiter_id', $user->id)
                ->inProgress()
                ->with(['table', 'orderItems.product'])
                ->latest()
                ->get();
            
            return view('dashboard.waiter', compact('stats', 'myOrders', 'activeOrders'));
        }

        if ($user->isChef()) {
            $kitchenOrders = Order::whereIn('status', ['Confirmada', 'En Preparación'])
                ->with(['table', 'orderItems' => function($q) {
                    $q->whereIn('status', ['Pendiente', 'En Preparación'])
                      ->with('product');
                }])
                ->get();

            return view('dashboard.chef', compact('stats', 'kitchenOrders'));
        }

        if ($user->isReceptionist()) {
            $todayReservations = Reservation::today()
                ->with(['customer', 'table'])
                ->orderBy('reservation_date')
                ->get();

            return view('dashboard.receptionist', compact(
                'stats', 
                'todayReservations', 
                'upcomingReservations',
                'activeOrders'
            ));
        }

        // Dashboard de administrador (vista completa)
        return view('dashboard.admin', compact(
            'stats',
            'activeOrders',
            'upcomingReservations',
            'lowStockIngredients',
            'topProducts',
            'salesByDay'
        ));
    }
}

