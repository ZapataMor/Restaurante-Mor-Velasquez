<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Table;

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
        $now = now();

        $tables = Table::with(['reservations', 'orders'])->get();

        foreach ($tables as $table) {

            // Buscar si tiene una reserva en ESTE MOMENTO
            $activeReservation = $table->reservations()
                ->where('status', 'confirmada')
                ->whereBetween('reservation_time', [
                    $now->copy()->subMinutes(90), // margen antes
                    $now->copy()->addMinutes(90), // margen después
                ])
                ->first();

            // Buscar si tiene ÓRDENES activas
            $activeOrder = $table->orders()
                ->whereIn('status', ['En Vista', 'Confirmada', 'En Preparación'])
                ->exists();

            // ESTADO REAL
            if ($activeOrder) {
                $table->status = 'Ocupada';

            } elseif ($activeReservation) {
                $table->status = 'Reservada';

            } else {
                $table->status = 'Disponible';
            }
        }

        return view('tables.map', compact('tables'));
    }


   public function assign($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);

        // Convertir la hora a Carbon real
        $resTime = \Carbon\Carbon::parse($reservation->reservation_time);

        $tables = Table::where('capacity', '>=', $reservation->people_count)
            ->whereDoesntHave('reservations', function ($query) use ($resTime) {

                // MOSTRAR mesas que NO tengan una reserva en un rango de 2 horas
                $query->whereBetween('reservation_time', [
                    $resTime->copy()->subHours(2),
                    $resTime->copy()->addHours(2),
                ]);

            })
            ->get();

        return view('tables.assign', compact('reservation', 'tables'));
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
        $reservation->status = 'confirmada';
        $reservation->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Mesa asignada correctamente.');
    }



}
