<?php

namespace App\Http\Controllers;

use App\Http\Resources\AchievementsResource;
use App\Models\User;
use App\Services\AchievementsService;
use Illuminate\Http\JsonResponse;

class AchievementsController extends Controller
{
    protected AchievementsService $achievementsService;

    public function __construct(AchievementsService $achievementsService)
    {
        $this->achievementsService = $achievementsService;
    }
    public function index (User $user): JsonResponse
    {
        // For demo exclude policies
        // $this->authorize('view', $user);

        $user->loadCount(['watched', 'comments']);

        // After calling loadCount, two new properties, watched_count and comments_count, are dynamically added to the $user object.
        $achievements = $this->achievementsService->getAchievements($user->watched_count,
            $user->comments_count);

        return response()->json(new AchievementsResource($achievements));
    }
}
