<?php

namespace Astrogoat\Courses\Database\Factories;

use Astrogoat\Courses\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(2),
            'description' => $this->faker->sentence,
            'layout' => array_key_first(siteLayouts()),
        ];
    }

    public function openForRegistration(bool $status = true)
    {
        return $this->state(fn () => ['is_open_for_registration' => $status]);
    }

    public function closedForRegistration(bool $status = true)
    {
        return $this->state(fn () => ['is_open_for_registration' => ! $status]);
    }

    public function enableWaitList(bool $status = true): CourseFactory
    {
        return $this->state(fn () => ['wait_list_enabled' => $status]);
    }

    public function disableWaitList(bool $status = true): CourseFactory
    {
        return $this->state(fn () => ['wait_list_enabled' => ! $status]);
    }

    public function started(Carbon $startedAt = null)
    {
        return $this->state(fn () => ['started_at' => $startedAt ?: now()->subDay()]);
    }

    public function ended(Carbon $endedAt = null)
    {
        return $this->state(fn () => ['ended_at' => $endedAt ?: now()->subDay()]);
    }

    public function maxParticipants(int $count)
    {
        return $this->state(fn () => ['max_participants' => $count]);
    }
}
