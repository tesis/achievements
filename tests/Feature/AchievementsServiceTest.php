<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievementsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations
        $this->artisan('migrate');
    }

    /** @test */
    public function test_user_with_0_comments_0_lessons_badge_beginner()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/achievements/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['watched_count' => 0])
            ->assertJsonFragment(['comments_count' => 0])
            ->assertJsonFragment(['unlocked_achievements' => [] ])
            ->assertJsonFragment(['next_available_achievements' => ["First Comment Written","First Lesson Watched"] ])
            ->assertJsonFragment(['current_badge' => "Beginner: 0 Achievements"])
            ->assertJsonFragment(['next_badge' => "Intermediate: 4 Achievements"])
            ->assertJsonFragment(['remaining_to_unlock_next_badge' => 4]);

    }

    /** @test */
    public function user_with_2_comments_10_lessons_badge_beginner()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $lessons = Lesson::factory()->count(15)->create();

        $user->lessons()->attach($lessons, ['watched' => 1]);

        $response = $this->getJson('/api/achievements/' . $user->id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['watched_count' => 15])
            ->assertJsonFragment(['comments_count' => 0])
            ->assertJsonFragment(['unlocked_achievements' => ["10 Lessons Watched","5 Lessons Watched","First Lesson Watched"] ])
            ->assertJsonFragment(['next_available_achievements' => ["25 Lessons Watched","First Comment Written"] ])
            ->assertJsonFragment(['current_badge' => "Master: 10 Achievements"])
            ->assertJsonFragment(['next_badge' => ''])
            ->assertJsonFragment(['remaining_to_unlock_next_badge' => 0]);
    }

    /** @test */
    public function benchmark_options_to_catch_bug ()
    {
        for ($i = 1; $i < 50; $i++) {
            $user = User::factory()->create();
            $this->actingAs($user);
            $lessons = Lesson::factory()->count($i)->create();

            $user->lessons()->attach($lessons, ['watched' => 1]);

            $response = $this->getJson('/api/achievements/' . $user->id);

            $response->assertStatus(200);
        }

    }

}
