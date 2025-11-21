<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\User;

class TableController extends Controller
{
    /**
     * Mostrar todas las mesas.
     */
    public function index()
    {
        $tables = Table::all(); // o paginación: Table::paginate(10)
        return view('tables.index', compact('tables'));
    }

    /**
     * Mostrar formulario para crear una nueva mesa.
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Guardar una nueva mesa en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number'   => 'required|integer|unique:tables,number',
            'capacity' => 'required|integer|min:1',
            'status'   => 'required|in:Disponible,Ocupada,Reservada,Necesita Limpieza',
        ]);

        Table::create([
            'number'   => $request->number,
            'capacity' => $request->capacity,
            'status'   => $request->status,
        ]);

        return redirect()->route('tables.index')
                         ->with('success', 'Mesa creada correctamente.');
    }

    /**
     * Mostrar una mesa específica.
     */
    public function show(Table $table)
    {
        return view('tables.show', compact('table'));
    }

    /**
     * Mostrar formulario para editar una mesa.
     */
    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    /**
     * Actualizar una mesa existente.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'number'   => 'required|integer|unique:tables,number,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'status'   => 'required|in:Disponible,Ocupada,Reservada,Necesita Limpieza',
        ]);

        $table->update([
            'number'   => $request->number,
            'capacity' => $request->capacity,
            'status'   => $request->status,
        ]);

        return redirect()->route('tables.index')
                         ->with('success', 'Mesa actualizada correctamente.');
    }

    /**
     * Eliminar una mesa.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')
                         ->with('success', 'Mesa eliminada correctamente.');
    }

    /**
     * Filtrar mesas disponibles usando scope.
     */
    public function available()
    {
        $tables = Table::available()->get();
        return view('tables.index', compact('tables'));
    }

    /**
     * Filtrar mesas ocupadas usando scope.
     */
    public function occupied()
    {
        $tables = Table::occupied()->get();
        return view('tables.index', compact('tables'));
    }

    /**
     * Filtrar mesas reservadas usando scope.
     */
    public function reserved()
    {
        $tables = Table::reserved()->get();
        return view('tables.index', compact('tables'));
    }

    public function map()
    {
        // Carga reservas y órdenes
        $tables = Table::with(['reservations', 'orders'])->get();

        $now = now();

        foreach ($tables as $table) {
            // Reservas activas y futuras
            $activeReservation = $table->activeReservation();
            $table->activeReservation = $activeReservation;
            $table->active_duration = $activeReservation
                ? $activeReservation->reservation_time->diffInMinutes($now)
                : null;

            $futureReservation = $table->futureReservation();
            $table->futureReservation = $futureReservation;
            $table->future_in_minutes = $futureReservation
                ? $now->diffInMinutes($futureReservation->reservation_time)
                : null;

            // ✅ ya no se toca $table->status
            // Todo lo relativo a mostrar si está ocupada o reservada lo hace $table->realStatus() en la vista
        }

        return view('tables.map', compact('tables'));
    }


   public function assign($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        $resTime = \Carbon\Carbon::parse($reservation->reservation_time);

        $waiters = User::where('role', 'mesero')
                    ->where('active', true)
                    ->get();

        $tables = Table::where('capacity', '>=', $reservation->people_count)
            ->whereDoesntHave('reservations', function ($query) use ($resTime) {
                $query->where('status', 'confirmada')
                    ->whereBetween('reservation_time', [
                        $resTime->copy()->subHours(2),
                        $resTime->copy()->addHours(2),
                    ]);
            })
            ->whereDoesntHave('orders', function ($query) {
                $query->whereIn('status', ['abierta', 'en_proceso']);
            })
            ->get();


        return view('tables.assign', compact('reservation', 'tables', 'waiters'));
    }

    public function assignStore(Request $request, $reservationId)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id'
        ]);

        $reservation = Reservation::findOrFail($reservationId);
        $table = Table::findOrFail($request->table_id);

        // Actualizar reserva
        $reservation->table_id = $table->id;
        $reservation->user_id = $request->user_id;
        $reservation->status = 'confirmada';
        $reservation->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Mesa asignada correctamente.');
    }



}
