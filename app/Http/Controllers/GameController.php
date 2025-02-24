<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Get All Games (With Filtering & Sorting)
     */
    public function index(Request $request)
    {
        $query = Game::where('user_id', Auth::id());

        // Filter by genre
        if ($request->has('genre')) {
            $query->where('genre', $request->genre);
        }

        // Sort by release date (default: newest first)
        if ($request->has('sort') && $request->sort == 'oldest') {
            $query->orderBy('release_date', 'asc');
        } else {
            $query->orderBy('release_date', 'desc');
        }

        return response()->json($query->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create a Game
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:100',
        ]);
    
        $game = Game::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'genre' => $request->genre,
        ]);
    
        return response()->json($game, 201);
    }

    /**
     * Get a Single Game
     */
    public function show($id)
    {
        $game = Game::where('user_id', Auth::id())->find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        return response()->json($game);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update a Game
     */
    public function update(Request $request, $id)
    {
        $game = Game::where('user_id', Auth::id())->find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:100',
        ]);

        $game->update($request->all());

        return response()->json($game);
    }

    /**
     * Delete a Game (Admin Restriction)
     */
    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $auth = auth();
        $user = $auth->user();

        // Only allow Admins OR the user who created the game to delete it
        // if (Auth::user()->role !== 'admin' && $game->user_id !== Auth::id()) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        // Only Admins or the creator of the game can delete it
        if ($user->role !== 'admin' && $user->id !== $game->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully']);
    }

}
