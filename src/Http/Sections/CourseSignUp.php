<?php

namespace Astrogoat\Courses\Http\Sections;

use Astrogoat\Courses\Enums\SignUpStatus;
use Astrogoat\Courses\Exceptions\UnableToSignUp;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;
use Helix\Lego\Http\Livewire\Section;

/**
 * @property Course $course;
 */
abstract class CourseSignUp extends Section
{
    protected SignUpStatus $status = SignUpStatus::PENDING;

    public static function dependsOn(): string
    {
        return Course::class;
    }

    public function mounted()
    {
        $this->status = SignUpStatus::tryFrom(request()->query->get('signup_status')) ?: SignUpStatus::PENDING;
    }

    public function getStatusProperty()
    {
        return $this->status;
    }

    public function canRegister(): bool
    {
        return $this->course->signupActionIsAvailable();
    }

    /**
     * @throws UnableToSignUp
     */
    public function register(string $email, string $name)
    {
        $this->remount();

        $pendingParticipant = Participant::pending($email, $name, $this->course);

        $status = $this->course->signUp($pendingParticipant);

        $this->status = $status;

        return $status;
    }
}
