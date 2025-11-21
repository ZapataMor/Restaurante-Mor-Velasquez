<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Livewire\Settings\{Appearance, Password, Profile, TwoFactor};

/*
|--------------------------------------------------------------------------
| 🌐 Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'inicio'])->name('inicio');
Route::get('/carta', [PublicController::class, 'carta'])->name('carta');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('contacto');

/*
|--------------------------------------------------------------------------
| 📅 Rutas de Reservas (Públicas)
|--------------------------------------------------------------------------
*/
Route::prefix('reservas')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservas.index');
    Route::post('/', [ReservationController::class, 'store'])->name('reservas.store');
    Route::delete('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservas.cancel');
});

Route::prefix('consultar-reserva')->group(function () {
    Route::get('/', [ReservationController::class, 'searchForm'])->name('consultar.reserva');
    Route::get('/buscar', [ReservationController::class, 'search'])->name('consultar.buscar');
});

/*
|--------------------------------------------------------------------------
| 🔐 Panel Administrativo / Autenticación
|--------------------------------------------------------------------------
*/
Route::get('admin', fn() => view('livewire.auth.login'))->name('home');
Route::get('login', fn() => view('livewire.auth.login'))->name('login');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| 📦 Rutas Protegidas (Requieren Autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 👥 Usuarios (Personal/Meseros)
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | 🍽️ Órdenes
    |--------------------------------------------------------------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');

        // Cambiar estado de la orden
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');

        // 👉 Nueva ruta: Cerrar orden (completarla)
        Route::patch('/{order}/close', [OrderController::class, 'close'])->name('close');

        // Vista de cocina
        Route::get('/kitchen/view', [OrderController::class, 'kitchen'])->name('kitchen');

        // Actualizar estado de items individuales
        Route::patch('/items/{item}/status', [OrderController::class, 'updateItemStatus'])->name('items.updateStatus');

        // Rutas para OrderItems
        Route::prefix('{order}/items')->name('items.')->group(function () {
            Route::get('/create', [OrderItemController::class, 'create'])->name('create');
            Route::post('/', [OrderItemController::class, 'store'])->name('store');
            Route::get('/{orderItem}/edit', [OrderItemController::class, 'edit'])->name('edit');
            Route::put('/{orderItem}', [OrderItemController::class, 'update'])->name('update');
            Route::delete('/{orderItem}', [OrderItemController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------  
    | 🪑 Mesas  
    |--------------------------------------------------------------------------  
    */
    Route::prefix('tables')->name('tables.')->group(function () {
        Route::get('/', [TableController::class, 'index'])->name('index');
        Route::get('/create', [TableController::class, 'create'])->name('create');
        Route::post('/', [TableController::class, 'store'])->name('store');
        Route::get('/{table}', [TableController::class, 'show'])->name('show');
        Route::get('/{table}/edit', [TableController::class, 'edit'])->name('edit');
        Route::put('/{table}', [TableController::class, 'update'])->name('update');
        Route::delete('/{table}', [TableController::class, 'destroy'])->name('destroy');

        // Cambiar estado
        Route::patch('/{table}/status', [TableController::class, 'updateStatus'])->name('updateStatus');

        // Mapa de mesas
        Route::get('/map/view', [TableController::class, 'map'])->name('map');

        // 👉 NUEVA RUTA añadida
        Route::get('/assign/{reservation}', [TableController::class, 'assign'])
            ->name('assign');

        Route::post('/assign/{reservation}', [TableController::class, 'assignStore'])
            ->name('assign.store');

        // API para mesas disponibles
        Route::get('/api/available', [TableController::class, 'available'])->name('api.available');
    });

    /*
    |--------------------------------------------------------------------------
    | 🍕 Productos
    |--------------------------------------------------------------------------
    */
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

        // Cambiar disponibilidad
        Route::patch('/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])->name('toggleAvailability');
    });

    /*
    |--------------------------------------------------------------------------
    | 📅 Reservas (Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin/reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'adminIndex'])->name('index');
        Route::get('/create', [ReservationController::class, 'adminCreate'])->name('create');
        Route::post('/', [ReservationController::class, 'adminStore'])->name('store');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::get('/{reservation}/edit', [ReservationController::class, 'adminEdit'])->name('edit');
        Route::put('/{reservation}', [ReservationController::class, 'adminUpdate'])->name('update');
        Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('destroy');

        // Cambiar estado
        Route::patch('/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('updateStatus');
    });

    /*
    |--------------------------------------------------------------------------
    | 🧾 Facturas
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create/{order}', [InvoiceController::class, 'create'])->name('create');
        Route::post('/{order}', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::patch('/{invoice}/pay', [InvoiceController::class, 'processPayment'])->name('pay');
    });

    /*
    |--------------------------------------------------------------------------
    | ⚙️ Configuración del Usuario (Settings)
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::redirect('/', 'settings/profile');

        Route::get('/profile', Profile::class)->name('profile.edit');
        Route::get('/password', Password::class)->name('password.edit');
        Route::get('/appearance', Appearance::class)->name('appearance.edit');

        Route::get('/two-factor', TwoFactor::class)
            ->middleware(
                when(
                    Features::canManageTwoFactorAuthentication()
                        && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                    ['password.confirm'],
                    []
                ),
            )
            ->name('two-factor.show');
    });

});