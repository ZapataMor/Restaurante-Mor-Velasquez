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
            'client_name' => [
                'required',
                'string',
                'min:8',
                'regex:/\s+/' // Debe tener nombre y apellido
            ],
            'client_contact' => [
                'required',
                'regex:/^3(0[0-9]|1[0-9]|2[0-9]|5[0-9])[0-9]{7}$/'
                // 300–399, pero controlado a rangos reales utilizados en Colombia
            ],
            'client_document' => [
                'required',
                'digits_between:8,15'
            ],
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'reservation_time' => [
                'required'
            ],
            'people_count' => [
                'required',
                'integer',
                'min:1'
            ],
            'notes' => [
                'nullable',
                'string'
            ],
        ], [
            // 🟡 Mensajes personalizados (opcional pero más elegante)
            'client_name.regex' => 'El nombre debe incluir al menos un apellido.',
            'client_contact.regex' => 'Debe ingresar un número colombiano válido (300–351, 310–320, etc).',
            'client_document.digits_between' => 'El documento debe tener al menos 8 dígitos.',
            'reservation_date.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
        ]);

        // Combinar fecha y hora
        $reservationDateTime = Carbon::parse(
            $request->reservation_date . ' ' . $request->reservation_time
        );

        Reservation::create([
            'client_name'      => $request->client_name,
            'client_contact'   => $request->client_contact,
            'client_document'  => $request->client_document,
            'reservation_time' => $reservationDateTime,
            'people_count'     => $request->people_count,
            'notes'            => $request->notes,
            'user_id'          => null, // mesero pendiente
            'table_id'         => null, // mesa pendiente
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
