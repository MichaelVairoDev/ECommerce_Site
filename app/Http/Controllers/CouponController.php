<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['apply']);
    }

    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:coupons|max:50',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean'
        ]);

        Coupon::create($validatedData);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón creado exitosamente.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validatedData = $request->validate([
            'code' => 'required|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean'
        ]);

        $coupon->update($validatedData);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón actualizado exitosamente.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cupón eliminado exitosamente.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:coupons,code'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        $cart = Auth::user()->cart;
        $total = $cart->total;

        if (!$coupon->isValid($total)) {
            return back()->with('error', 'El cupón no es válido o ha expirado.');
        }

        $discount = $coupon->calculateDiscount($total);
        session(['coupon_id' => $coupon->id, 'discount' => $discount]);

        return back()->with('success', 'Cupón aplicado exitosamente.');
    }
}