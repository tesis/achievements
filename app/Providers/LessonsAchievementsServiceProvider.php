<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LessonsAchievementsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */

    public function register(): void
    {
        $this->app->singleton('LessonsAchievements', function () {
            return [
                1  => 'First Lesson Watched',
                5  => '5 Lessons Watched',
                10 => '10 Lessons Watched',
                25 => '25 Lessons Watched',
                50 => '50 Lessons Watched',
            ];
        });
    }
}