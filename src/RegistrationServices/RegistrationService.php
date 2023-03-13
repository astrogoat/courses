<?php

namespace Astrogoat\Courses\RegistrationServices;

use Astrogoat\Courses\Enums\SignUpStatus;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;

abstract class RegistrationService
{
    public Course $course;
    public readonly array $service;

    abstract public function formOptionsComponent(): ?string;

    abstract public function redirectUrl(): string;

    abstract public function signup(Participant $participant, Course $course): SignUpStatus;

    public function setCourse(Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function setService(array $service): static
    {
        $this->service = $service;

        return $this;
    }
}
