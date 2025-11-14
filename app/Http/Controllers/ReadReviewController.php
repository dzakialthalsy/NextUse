<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReadReviewController extends Controller
{
    /**
     * Menampilkan semua review untuk user tertentu.
     */
    public function show(Request $request)
    {
        $userId = $request->query('user_id') ?? $request->route('user_id');
        
        if (!$userId) {
            return redirect()->back()->with('error', 'User ID tidak ditemukan.');
        }

        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Get all reviews for this user
        $reviews = Review::where('reviewed_user_id', $userId)
            ->with(['reviewer' => function ($query) {
                $query->select('id', 'name', 'email');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalReviews = Review::where('reviewed_user_id', $userId)->count();
        $averageRating = Review::where('reviewed_user_id', $userId)->avg('rating') ?? 0;
        $ratingDistribution = Review::where('reviewed_user_id', $userId)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->keyBy('rating');

        // For now, using review count as transaction count placeholder
        $transactionCount = $totalReviews; // Replace with actual transaction count when available

        // Check if current user is viewing their own reviews
        $isOwnProfile = auth()->check() && auth()->id() == $userId;

        return view('read-review', [
            'user' => $user,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => round($averageRating, 1),
            'ratingDistribution' => $ratingDistribution,
            'transactionCount' => $transactionCount,
            'isOwnProfile' => $isOwnProfile,
        ]);
    }
}

