<?php
// tests/Unit/AchievementsServiceTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AchievementsService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AchievementsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AchievementsService $achievementsService;

    protected function setUp(): void
    {
        parent::setUp();
        // Run migrations
        $this->artisan('migrate');

        $this->achievementsService = app(AchievementsService::class);
    }

    /** @test */
    public function it_calculates_achievements_correctly()
    {
        $lessonsAchievements = [
            1  => 'First Lesson Watched',
            5  => '5 Lessons Watched',
            10 => '10 Lessons Watched',
            25 => '25 Lessons Watched',
            50 => '50 Lessons Watched',
        ];

        $commentsAchievements = [
            1  => 'First Comment Written',
            3  => '3 Comments Written',
            5  => '5 Comments Written',
            10 => '10 Comments Written',
            20 => '20 Comments Written',
        ];

        $badges = [
            0  => 'Beginner: 0 Achievements',
            4  => 'Intermediate: 4 Achievements',
            8  => 'Advanced: 8 Achievements',
            10 => 'Master: 10 Achievements',
        ];

        $service = new AchievementsService($lessonsAchievements, $commentsAchievements, $badges);

        $result = $service->getAchievements(10, 5);

        $this->assertEquals(10, $result['watched_count']);
        $this->assertEquals(5, $result['comments_count']);
        $this->assertEquals(
            ['First Lesson Watched', '5 Lessons Watched', '10 Lessons Watched', 'First Comment Written', '3 Comments Written', '5 Comments Written'],
            $result['unlocked_achievements']
        );
        $this->assertEquals(
            ['25 Lessons Watched', '10 Comments Written'],
            $result['next_available_achievements']
        );
        $this->assertEquals('Master: 10 Achievements', $result['current_badge']);
        $this->assertEquals('', $result['next_badge']);
        $this->assertEquals(0, $result['remaining_to_unlock_next_badge']);
    }
}

