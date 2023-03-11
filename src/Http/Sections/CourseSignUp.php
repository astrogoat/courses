<?php

namespace Astrogoat\Courses\Http\Sections;

use Astrogoat\Courses\Models\Course;
use Helix\Lego\Http\Livewire\Section;

abstract class CourseSignUp extends Section
{
    private Course $course;

    public static function dependsOn(): string
    {
        return Course::class;
    }

    public function canRegister(): bool
    {
        return $this->course->signupActionIsAvailable();
    }

    public function register(string $email, string $name)
    {
    }
}
