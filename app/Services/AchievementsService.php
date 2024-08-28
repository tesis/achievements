<?php

namespace App\Services;

class AchievementsService
{
    protected array $lessonsAchievements;
    protected array $commentsAchievements;
    protected array $badges;

    public function __construct(array $lessonsAchievements, array $commentsAchievements, array $badges)
    {
        $this->lessonsAchievements = $lessonsAchievements;
        $this->commentsAchievements = $commentsAchievements;
        $this->badges = $badges;
    }

    public function getAchievements (int $watchedCount, int $commentsCount)
    :array
    {
        $lessons = $this->iterateAchievements($this->lessonsAchievements, $watchedCount);
        $comments = $this->iterateAchievements($this->commentsAchievements, $commentsCount);
        $data = array_merge_recursive($lessons, $comments);

        $badgesCount = $watchedCount + $commentsCount;
        $iterateBadges = $this->iterateBadges($this->badges, $badgesCount);

        return [
            'watched_count' => $watchedCount,
            'comments_count' => $commentsCount,
            'unlocked_achievements' => $data['unlocked_achievements'],
            'next_available_achievements' => $data['next_available_achievements'],
            'current_badge' => $iterateBadges['current_badge'],
            'next_badge' => $iterateBadges['next_badge'],
            'remaining_to_unlock_next_badge' => $iterateBadges['remaining_to_unlock_next_badge']
        ];

    }

    protected function iterateAchievements ($achievements,
        $achievementsCount):array
    {
        $nextAvailable = [];
        $unlocked = [];

        foreach ($achievements as $key => $achievement) {
            if ($achievementsCount < $key) {
                $nextAvailable[] = $achievement;
                break;
            } else {
                $unlocked[] = $achievement;
            }
        }

        return [
            'next_available_achievements' => $nextAvailable,
            'unlocked_achievements' => $unlocked,
        ];
    }

    protected function iterateBadges($badges, $badgesCount):array
    {
        $currentBadge = '';
        $nextBadge = '';
        $remainingToUnlock = 0;

        foreach ($badges as $key => $badge) {
            if ($badgesCount < $key) {
                if (empty($nextBadge)) {
                    $nextBadge = $badge;
                }
                $remainingToUnlock = $key - $badgesCount;
                break;
            } else {
                $currentBadge = $badge;
            }
        }

        return [
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlock,
            'current_badge' => $currentBadge,
        ];
    }
}
