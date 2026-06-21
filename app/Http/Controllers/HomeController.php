<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_available', true)->get();
        $categories = Product::select('category')->distinct()->get();
        
        return view('home', compact('products', 'categories'));
    }
}
