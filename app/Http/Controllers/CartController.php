<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = auth()->user()->cart;
        return view('cart.index', compact('cart'));
    }

    public function addItem(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $cart = auth()->user()->cart ?? auth()->user()->cart()->create();

        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function updateItem(Request $request, $cartItemId)
    {
        $cartItem = auth()->user()->cart->items()->findOrFail($cartItemId);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $cartItem->product->price,
        ]);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function removeItem($cartItemId)
    {
        auth()->user()->cart->items()->findOrFail($cartItemId)->delete();
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear()
    {
        if (auth()->user()->cart) {
            auth()->user()->cart->items()->delete();
        }
        return back()->with('success', 'Carrito vaciado.');
    }

    public function checkout()
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // Verificar stock antes de proceder
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "No hay suficiente stock de {$item->product->name}.");
            }
        }

        return view('orders.checkout', compact('cart'));
    }
}
