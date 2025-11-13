<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $query = Table::withCount(['orders', 'reservations']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tables = $query->orderBy('number')->paginate(20);

        // Estadísticas
        $stats = [
            'available' => Table::available()->count(),
            'occupied' => Table::occupied()->count(),
            'reserved' => Table::reserved()->count(),
            'needs_cleaning' => Table::where('status', 'Necesita Limpieza')->count(),
        ];

        return view('tables.index', compact('tables', 'stats'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer|unique:tables,number',
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:Disponible,Ocupada,Reservada,Necesita Limpieza',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $table = Table::create($request->all());

        return redirect()->route('tables.index')
            ->with('success', 'Mesa creada exitosamente');
    }

    public function show(Table $table)
    {
        $table->load([
            'orders' => fn($q) => $q->latest()->take(10),
            'reservations' => fn($q) => $q->latest()->take(10)
        ]);

        return view('tables.show', compact('table'));
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer|unique:tables,number,' . $table->table_id . ',table_id',
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:Disponible,Ocupada,Reservada,Necesita Limpieza',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $table->update($request->all());

        return redirect()->route('tables.index')
            ->with('success', 'Mesa actualizada exitosamente');
    }

    public function destroy(Table $table)
    {
        try {
            $table->delete();
            return redirect()->route('tables.index')
                ->with('success', 'Mesa eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la mesa porque tiene registros asociados');
        }
    }

    // Cambiar estado
    public function updateStatus(Request $request, Table $table)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Disponible,Ocupada,Reservada,Necesita Limpieza',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Estado inválido'], 400);
        }

        $table->status = $request->status;
        $table->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado',
            'status' => $table->status
        ]);
    }

    // Vista de mapa de mesas
    public function map()
    {
        $tables = Table::with(['orders' => function($q) {
            $q->whereIn('status', ['En Vista', 'Confirmada', 'En Preparación', 'Lista', 'Entregada'])
              ->with('waiter', 'orderItems');
        }])->orderBy('number')->get();

        return view('tables.map', compact('tables'));
    }

    // API: Obtener mesas disponibles
    public function available()
    {
        $tables = Table::available()->get();
        return response()->json($tables);
    }
}