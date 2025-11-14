<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CreateReviewController extends Controller
{
    /**
     * Menampilkan form untuk memberikan review.
     */
    public function create(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan review.');
        }

        $reviewedUserId = $request->query('user_id');
        
        if (!$reviewedUserId) {
            return redirect()->back()->with('error', 'User ID tidak ditemukan.');
        }

        $reviewedUser = User::find($reviewedUserId);
        
        if (!$reviewedUser) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Prevent users from reviewing themselves
        if (Auth::id() == $reviewedUserId) {
            return redirect()->back()->with('error', 'Anda tidak dapat memberikan review kepada diri sendiri.');
        }

        // Calculate average rating and transaction count (placeholder)
        $averageRating = Review::where('reviewed_user_id', $reviewedUserId)
            ->avg('rating') ?? 0;
        $reviewCount = Review::where('reviewed_user_id', $reviewedUserId)->count();
        
        // For now, using review count as transaction count placeholder
        $transactionCount = $reviewCount; // Replace with actual transaction count when available

        return view('create-review', [
            'reviewedUser' => $reviewedUser,
            'averageRating' => round($averageRating, 1),
            'transactionCount' => $transactionCount,
        ]);
    }

    /**
     * Menyimpan review baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan review.');
        }

        $validator = Validator::make($request->all(), [
            'reviewed_user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review_text' => 'required|string|min:20|max:500',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048', // 2MB max
            'show_name' => 'nullable|boolean',
        ], [
            'reviewed_user_id.required' => 'User ID wajib diisi',
            'reviewed_user_id.exists' => 'User tidak ditemukan',
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'review_text.required' => 'Ulasan wajib diisi',
            'review_text.min' => 'Ulasan minimal 20 karakter',
            'review_text.max' => 'Ulasan maksimal 500 karakter',
            'images.max' => 'Maksimal 3 gambar',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus JPG atau PNG',
            'images.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prevent users from reviewing themselves
        if (Auth::id() == $request->reviewed_user_id) {
            return back()
                ->withErrors(['reviewed_user_id' => 'Anda tidak dapat memberikan review kepada diri sendiri.'])
                ->withInput();
        }

        // Check if user already reviewed this user (optional - remove if multiple reviews are allowed)
        $existingReview = Review::where('reviewer_id', Auth::id())
            ->where('reviewed_user_id', $request->reviewed_user_id)
            ->first();

        if ($existingReview) {
            return back()
                ->withErrors(['review' => 'Anda sudah memberikan review untuk user ini.'])
                ->withInput();
        }

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('reviews', 'public');
                    if ($path) {
                        $imagePaths[] = $path;
                    }
                }
            }
        }

        // Create review
        Review::create([
            'reviewed_user_id' => $request->reviewed_user_id,
            'reviewer_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'review_text' => $request->review_text,
            'images' => !empty($imagePaths) ? $imagePaths : null,
            'show_name' => $request->has('show_name') ? (bool)$request->show_name : true,
        ]);

        return redirect()
            ->route('review.read', ['user_id' => $request->reviewed_user_id])
            ->with('success', 'Review berhasil dikirim. Terima kasih atas ulasan Anda!');
    }
}

