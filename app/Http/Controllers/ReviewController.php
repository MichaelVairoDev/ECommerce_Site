<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Check if user already reviewed this product
        $existingReview = $product->reviews()->where('user_id', Auth::id())->first();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Ya has dejado una reseña para este producto.');
        }
        
        // Create review
        $review = new Review([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            // Approve automatically only if admin, otherwise require approval
            'approved' => Auth::user()->is_admin,
        ]);
        
        $product->reviews()->save($review);
        
        return redirect()->back()->with('success', 'Tu reseña ha sido enviada correctamente' . 
            (!Auth::user()->is_admin ? ' y está pendiente de aprobación.' : '.'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user can edit this review
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            abort(403, 'No tienes permiso para editar esta reseña.');
        }
        
        // Validate request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        // Update review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            // If user is not admin, reset approval status
            'approved' => Auth::user()->is_admin ? $review->approved : false,
        ]);
        
        return redirect()->back()->with('success', 'Tu reseña ha sido actualizada correctamente' . 
            (!Auth::user()->is_admin ? ' y está pendiente de aprobación.' : '.'));
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Check if user can delete this review
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            abort(403, 'No tienes permiso para eliminar esta reseña.');
        }
        
        $review->delete();
        
        return redirect()->back()->with('success', 'La reseña ha sido eliminada correctamente.');
    }
    
    /**
     * Approve the specified review.
     */
    public function approve(Review $review)
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'No tienes permiso para aprobar reseñas.');
        }
        
        $review->update(['approved' => true]);
        
        return redirect()->back()->with('success', 'La reseña ha sido aprobada correctamente.');
    }
    
    /**
     * Reject the specified review.
     */
    public function reject(Review $review)
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'No tienes permiso para rechazar reseñas.');
        }
        
        $review->delete();
        
        return redirect()->back()->with('success', 'La reseña ha sido rechazada y eliminada correctamente.');
    }
}
