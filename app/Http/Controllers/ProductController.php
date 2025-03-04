<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%");
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('release_date', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('release_date', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $platforms = Product::select('platform')->distinct()->get();

        return view('products.index', compact('products', 'categories', 'platforms'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'platform' => 'required',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|max:255',
            'developer' => 'nullable|max:255',
            'release_date' => 'nullable|date',
            'rating' => 'nullable|max:10',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $product = Product::create($validatedData);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'platform' => 'required',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|max:255',
            'developer' => 'nullable|max:255',
            'release_date' => 'nullable|date',
            'rating' => 'nullable|max:10',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $validatedData['slug'] = Str::slug($validatedData['name']);
        $product->update($validatedData);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
