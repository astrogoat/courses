<?php

namespace Astrogoat\Courses\Database\Factories;

use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseParticipantsFactory extends Factory
{
    protected $model = Participant::class;

    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
        ];
    }
}
