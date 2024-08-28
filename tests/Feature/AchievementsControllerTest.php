<?php
// tests/Feature/AchievementsControllerTest.php
namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Lesson;
use App\Services\AchievementsService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;

class AchievementsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations
        $this->artisan('migrate');

        // Seed the database
        // $this->artisan('db:seed');
    }

    /** @test */
    public function it_returns_achievements_for_authenticated_user()
    {
        $user = User::factory()->create();

        $lessons = Lesson::factory()->count(10)->create();
        foreach ($lessons as $lesson) {
            $user->watched()->attach($lesson->id, ['watched' => 1]);
        }

        Comment::factory()->count(5)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        // Mock AchievementsService
        $this->mock(AchievementsService::class, function ($mock) {
            $mock->shouldReceive('getAchievements')
                ->once()
                ->with(10, 5) // Expected counts based on the created relations
                ->andReturn([
                    'watched_count' => 10,
                    'comments_count' => 5,
                    'unlocked_achievements' => [
                        'First Lesson Watched',
                        '5 Lessons Watched',
                        '10 Lessons Watched',
                    ],
                    'next_available_achievements' => [
                        '25 Lessons Watched',
                    ],
                    'current_badge' => 'Intermediate: 4 Achievements',
                    'next_badge' => 'Advanced: 8 Achievements',
                    'remaining_to_unlock_next_badge' => 3
                ]);
        });

        $response = $this->getJson('/api/achievements/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'watched_count' => 10,
                'comments_count' => 5,
                'unlocked_achievements' => [
                    'First Lesson Watched',
                    '5 Lessons Watched',
                    '10 Lessons Watched',
                ],
                'next_available_achievements' => [
                    '25 Lessons Watched',
                ],
                'current_badge' => 'Intermediate: 4 Achievements',
                'next_badge' => 'Advanced: 8 Achievements',
                'remaining_to_unlock_next_badge' => 3
            ]);
    }
}

