<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()
            ->count(2)
            ->create();

        $comments = Comment::factory()
            ->count(10)
            ->create();

        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        foreach (Lesson::all() as $lesson) {
            $users = User::inRandomOrder()->take(1)->pluck('id');
            foreach ($users as $user) {
                $lesson->users()->attach($users, ['watched' => rand(0,1)]);
            }
        }
    }
}
