<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * 🟡 Mostrar el formulario para crear una nueva reserva.
     */
    public function index()
    {
        return view('publica.reservas.reservas');
    }

    /**
     * 🟢 Guardar una nueva reserva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_contact'   => 'required|string|max:20',
            'client_document' => 'required|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people_count'     => 'required|integer|min:1',
            // ❌ El cliente NO asigna mesa, así que no se valida aquí
            'notes'            => 'nullable|string',
        ]);

        // Combinar fecha y hora
        $reservationDateTime = Carbon::parse(
            $request->reservation_date . ' ' . $request->reservation_time
        );

        // Crear la reserva SIN MESA por ahora
        Reservation::create([
            'client_name'      => $request->client_name,
            'client_contact'   => $request->client_contact,
            'client_document' => $request->client_document,
            'reservation_time' => $reservationDateTime,
            'people_count'     => $request->people_count,
            'notes'            => $request->notes,
            
            //❗ La mesa y el msero quedan pendientes para que el recepcionista la asigne
            'user_id'          => null,
            'table_id'         => null,
        ]);

        return redirect()->route('consultar.reserva')
                        ->with('success', '✅ Reserva registrada correctamente. Mesa pendiente por asignar.');
    }


    /**
     * 🔵 Mostrar formulario para consultar una reserva.
     */
    public function searchForm()
    {
        return view('publica.reservas.consultar');
    }

    /**
     * 🟣 Buscar reservas por nombre, contacto o documento.
     */
    public function search(Request $request)
    {
        $request->validate(['query' => 'required|string']);

        $query = $request->input('query');

        $reservas = Reservation::with('user')
            ->where('client_name', 'like', "%{$query}%")
            ->orWhere('client_contact', 'like', "%{$query}%")
            ->orWhere('client_document', 'like', "%{$query}%")
            ->get();

        if ($reservas->isEmpty()) {
            return redirect()->back()->with('error', '❌ No se encontró ninguna reserva con esos datos.');
        }

        return view('publica.reservas.resultado', compact('reservas', 'query'));
    }

    public function cancel(Reservation $reservation)
    {
        // Si quieres eliminarla:
        // $reservation->delete();

        // O cambiar su estado a 'cancelada':
        $reservation->update(['status' => 'cancelada']);

        return redirect()->back()->with('success', 'Reserva cancelada correctamente.');
    }

}
