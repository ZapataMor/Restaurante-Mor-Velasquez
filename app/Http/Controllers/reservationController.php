<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * 🟡 Muestra el formulario para crear una nueva reserva.
     */
    public function index()
    {
        $tables = Table::all(); // Obtiene todas las mesas disponibles
        return view('publica.reservas.reservas', compact('tables'));
    }

    /**
     * 🟢 Guarda una nueva reserva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_contact'   => 'required|string|max:20',
            'cliente_document' => 'required|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people_count'     => 'required|integer|min:1',
        ]);

        // Combinar fecha y hora
        $fechaHora = \Carbon\Carbon::parse(
            $request->reservation_date . ' ' . $request->reservation_time
        );

        // Buscar mesero aleatorio si no hay usuario autenticado
        $mesero = Auth::user() ?? User::where('role', 'mesero')->inRandomOrder()->first();

        if (!$mesero) {
            return redirect()->back()->with('error', '❌ No hay meseros disponibles para asignar.');
        }

        Reservation::create([
            'client_name'      => $request->client_name,
            'client_contact'   => $request->client_contact,
            'cliente_document' => $request->cliente_document,
            'reservation_time' => $fechaHora,
            'people_count'     => $request->people_count,
            'table_id'         => $request->table_id ?? null,
            'notes'            => $request->notes ?? null,
            'user_id'          => $mesero->id, // 👈 asigna el mesero automáticamente
        ]);

        return redirect()->route('consultar.reserva')->with('success', '✅ Reserva registrada correctamente.');
    }

    /**
     * 🔵 Muestra el formulario para consultar una reserva.
     */
    public function searchForm()
    {
        return view('publica.reservas.consultar');
    }


    /**
     * 🟣 Busca una reserva existente por documento, nombre o contacto.
     */
    public function search(Request $request)
    {
        $request->validate(['query' => 'required|string']);
        
        $query = $request->input('query');

        $reservas = Reservation::where('client_name', 'like', '%' . $query . '%')
            ->orWhere('client_contact', 'like', '%' . $query . '%')
            ->orWhere('cliente_document', 'like', '%' . $query . '%')
            ->with(['table', 'user'])
            ->get();

        if ($reservas->isEmpty()) {
            return redirect()->back()->with('error', '❌ No se encontró ninguna reserva con esos datos.');
        }

        return view('publica.reservas.resultado', compact('reservas', 'query'));
    }

}

