<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class IndexController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        return view('index', compact('products'));
    }
} 