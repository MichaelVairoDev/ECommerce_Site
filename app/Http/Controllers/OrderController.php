<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cart = Auth::user()->cart;

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

    public function store(Request $request)
    {
        $cart = Auth::user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required_if:same_address,0|string|nullable',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock y calcular total
            $total = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("No hay suficiente stock de {$item->product->name}.");
                }
                $total += $item->price * $item->quantity;
            }

            // Crear el pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->same_address ? $request->shipping_address : $request->billing_address,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            // Crear los items del pedido y actualizar stock
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // Actualizar stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Limpiar el carrito
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.confirmation', $order)
                ->with('success', 'Pedido realizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }

    public function confirmation(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.confirmation', compact('order'));
    }
}
