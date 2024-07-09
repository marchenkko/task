<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeamController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($request->user()->teams);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create($request->all());

        $request->user()->teams()->attach($team->id);

        return response()->json($team, 201);
    }

    /**
     * @param Request $request
     * @param $teamId
     * @return JsonResponse
     */
    public function addUser(Request $request, $teamId): JsonResponse
    {
        $team = Team::findOrFail($teamId);

        if ($team->users()->where('user_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'User already in the team'], 409);
        }

        $team->users()->attach($request->user()->id);

        return response()->json(['message' => 'User added to the team'], 201);
    }

    /**
     * @param $teamId
     * @param $userId
     * @return JsonResponse
     */
    public function removeUser($teamId, $userId): JsonResponse
    {
        $team = Team::findOrFail($teamId);

        if ($team->users()->detach($userId)) {
            return response()->json(['message' => 'User removed from the team'], 200);
        }

        return response()->json(['message' => 'User not found in the team'], 404);
    }
}

