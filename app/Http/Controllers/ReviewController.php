<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Product $product)
    {
        // Check if user has purchased the product
        $hasPurchased = $product->orders()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()
                ->with('error', 'You can only review products you have purchased.');
        }

        // Check if user has already reviewed this product
        $hasReviewed = $product->reviews()
            ->where('user_id', Auth::id())
            ->exists();

        if ($hasReviewed) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this product.');
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'images.*' => 'nullable|image|max:5120' // 5MB max per image
        ]);

        // Verify purchase and no existing review
        $product = Product::findOrFail($request->product_id);
        
        $hasPurchased = $product->orders()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()
                ->with('error', 'You can only review products you have purchased.')
                ->withInput();
        }

        $hasReviewed = $product->reviews()
            ->where('user_id', Auth::id())
            ->exists();

        if ($hasReviewed) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this product.')
                ->withInput();
        }

        // Create the review
        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $review->images()->create([
                    'path' => $path
                ]);
            }
        }

        // Update product average rating
        $product->updateAverageRating();

        return redirect()->route('reviews.index')
            ->with('success', 'Your review has been submitted successfully!');
    }
} 