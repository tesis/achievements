<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AchievementsService;

class AchievementsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public function register(): void
    {
        $this->app->singleton(AchievementsService::class, function ($app) {
            return new AchievementsService(
                $app->make('LessonsAchievements'),
                $app->make('CommentsAchievements'),
                $app->make('Badges')
            );
        });
    }
}
