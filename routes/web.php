<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Settings\{Appearance, Password, Profile, TwoFactor};

/*
|--------------------------------------------------------------------------
| 🌐 Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::view('/', 'publica.inicio')->name('inicio');
Route::view('/carta', 'publica.carta')->name('carta');
Route::view('/contacto', 'pages.contacto')->name('contacto');

/*
|--------------------------------------------------------------------------
| 📅 Rutas de Reservas (Públicas)
|--------------------------------------------------------------------------
*/
Route::prefix('reservas')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('reservas.index');
    Route::post('/', [ReservationController::class, 'store'])->name('reservas.store');
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
        
        // Vista de cocina
        Route::get('/kitchen/view', [OrderController::class, 'kitchen'])->name('kitchen');
        
        // Actualizar estado de items individuales
        Route::patch('/items/{item}/status', [OrderController::class, 'updateItemStatus'])->name('items.updateStatus');
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
        
        // Mapa de mesas
        Route::get('/map/view', [TableController::class, 'map'])->name('map');
        
        // Cambiar estado
        Route::patch('/{table}/status', [TableController::class, 'updateStatus'])->name('updateStatus');
        
        // API para obtener mesas disponibles
        Route::get('/api/available', [TableController::class, 'available'])->name('api.available');
    });

    /*
    |--------------------------------------------------------------------------
    | 👥 Clientes
    |--------------------------------------------------------------------------
    */
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
        
        // Búsqueda de clientes (para formularios)
        Route::get('/api/search', [CustomerController::class, 'search'])->name('api.search');
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
    | 🥕 Ingredientes
    |--------------------------------------------------------------------------
    */
    Route::prefix('ingredients')->name('ingredients.')->group(function () {
        Route::get('/', [IngredientController::class, 'index'])->name('index');
        Route::get('/create', [IngredientController::class, 'create'])->name('create');
        Route::post('/', [IngredientController::class, 'store'])->name('store');
        Route::get('/{ingredient}', [IngredientController::class, 'show'])->name('show');
        Route::get('/{ingredient}/edit', [IngredientController::class, 'edit'])->name('edit');
        Route::put('/{ingredient}', [IngredientController::class, 'update'])->name('update');
        Route::delete('/{ingredient}', [IngredientController::class, 'destroy'])->name('destroy');
        
        // Movimientos de inventario
        Route::post('/{ingredient}/movements', [IngredientController::class, 'addMovement'])->name('movements.store');
        Route::get('/movements/history', [IngredientController::class, 'movementsHistory'])->name('movements.history');
    });

    /*
    |--------------------------------------------------------------------------
    | 🧾 Facturas
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/print', [InvoiceController::class, 'print'])->name('print');
        Route::get('/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('pdf');
        
        // Procesar pago
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

    /*
    |--------------------------------------------------------------------------
    | 👨‍💼 Usuarios (Solo Administradores)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Administrador'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        
        // Cambiar estado activo
        Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggleActive');
    });

});