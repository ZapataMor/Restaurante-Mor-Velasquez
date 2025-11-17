<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PublicController extends Controller
{
    /**
     * 🌟 Página de inicio
     */
    public function inicio()
    {
        return view('publica.inicio');
    }

    /**
     * 🍽️ Carta del restaurante
     */
    public function carta()
    {
        $products = Product::where('status', 'Activo')->get();
        return view('publica.carta', compact('products'));
    }

    /**
     * 📞 Página de contacto
     */
    public function contacto()
    {
        return view('publica.contacto');
    }
}
