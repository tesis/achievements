<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BadgesServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */

    public function register(): void
    {
        $this->app->singleton('Badges', function () {
            return [
                0  => 'Beginner: 0 Achievements',
                4  => 'Intermediate: 4 Achievements',
                8  => 'Advanced: 8 Achievements',
                10 => 'Master: 10 Achievements',
            ];
        });
    }
}
