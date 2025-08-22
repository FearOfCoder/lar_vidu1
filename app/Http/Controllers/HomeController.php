<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Admin dashboard data
            $stats = [
                'products'   => Product::count(),
                'categories' => Category::count(),
            ];
            $recentProducts = Product::with('category')->orderByDesc('id')->limit(8)->get();

            return view('home', compact('stats', 'recentProducts'));
        }

        // Public/User: show product list on homepage
        $products = Product::with('category')->orderByDesc('id')->paginate(12);
        return view('home', compact('products'));
    }
}
