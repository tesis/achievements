<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommentsAchievementsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */

    public function register(): void
    {
        $this->app->singleton('CommentsAchievements', function () {
            return [
                1 => 'First Comment Written',
                3 => '3 Comments Written',
                5 => '5 Comments Written',
                10 => '10 Comments Written',
                20 => '20 Comments Written',
            ];
        });
    }
}
