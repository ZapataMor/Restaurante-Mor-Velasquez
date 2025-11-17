<?php

namespace App\Http\Controllers;

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
}
