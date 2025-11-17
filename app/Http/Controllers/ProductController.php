<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Mostrar todos los productos.
     */
    public function index()
    {
        $products = Product::all(); // o paginación: Product::paginate(10)
        return view('products.index', compact('products'));
    }

    /**
     * Mostrar formulario para crear un producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guardar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => ['required', Rule::in(['Entrada', 'Plato Fuerte', 'Bebida', 'Postre', 'Adicional'])],
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => ['required', Rule::in(['Activo', 'Inactivo'])],
        ]);

        $data = $request->all();

        // Manejo de imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Mostrar un producto específico.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Mostrar formulario para editar un producto.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => ['required', Rule::in(['Entrada', 'Plato Fuerte', 'Bebida', 'Postre', 'Adicional'])],
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => ['required', Rule::in(['Activo', 'Inactivo'])],
        ]);

        $data = $request->all();

        // Manejo de imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Filtrar productos activos.
     */
    public function active()
    {
        $products = Product::where('status', 'Activo')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Filtrar productos por categoría.
     */
    public function category($category)
    {
        $products = Product::where('category', $category)->get();
        return view('products.index', compact('products'));
    }
}
