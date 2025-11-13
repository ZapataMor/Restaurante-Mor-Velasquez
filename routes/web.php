<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\ReservationController;
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
    Route::get('/', [ReservationController::class, 'index'])->name('reservas.index'); // Formulario para crear reserva
    Route::post('/', [ReservationController::class, 'store'])->name('reservas.store'); // Guardar nueva reserva
});

Route::prefix('consultar-reserva')->group(function () {
    // 🟢 Mostrar formulario
    Route::get('/', [ReservationController::class, 'searchForm'])
        ->name('consultar.reserva');

    // 🟣 Procesar la búsqueda
    Route::get('/buscar', [ReservationController::class, 'search'])
        ->name('consultar.buscar');
});


/*
|--------------------------------------------------------------------------
| 🔐 Panel Administrativo / Autenticación
|--------------------------------------------------------------------------
*/
Route::get('admin', fn() => view('livewire.auth.login'))->name('home');

Route::middleware('auth')->get('/dashboard', fn() => redirect()->route('login'))->name('login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| ⚙️ Configuración del Usuario (Settings)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('settings')->group(function () {
    Route::redirect('/', 'settings/profile');

    Route::get('/profile', Profile::class)->name('profile.edit');
    Route::get('/password', Password::class)->name('user-password.edit');
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
