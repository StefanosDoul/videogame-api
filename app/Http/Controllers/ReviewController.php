<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Get all reviews for a specific game
     */
    public function index($gameId)
    {
        $game = Game::find($gameId);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        return response()->json($game->reviews()->with('user:id,name')->get());
    }

    /**
     * Store a new review
     */
    public function store(Request $request, $gameId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        // Check if game exists
        $game = Game::find($gameId);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $review = Review::create([
            'game_id' => $gameId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update a review
     */
    public function update(Request $request, $id)
    {
        $review = Review::where('user_id', Auth::id())->find($id);
        if (!$review) {
            return response()->json(['message' => 'Unauthorized or review not found'], 403);
        }

        $request->validate([
            'rating' => 'integer|min:1|max:5',
            'review' => 'string',
        ]);

        $review->update($request->all());

        return response()->json($review);
    }

    /**
     * Delete a review
     */
    public function destroy(string $id)
    {
        $review = Review::where('user_id', Auth::id())->find($id);
        if (!$review) {
            return response()->json(['message' => 'Unauthorized or review not found'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
