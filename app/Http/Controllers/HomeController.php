<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::where('release_date', '>=', now()->subMonths(3))
            ->inStock()
            ->latest('release_date')
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
