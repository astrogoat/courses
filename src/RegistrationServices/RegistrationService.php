<?php

namespace Astrogoat\Courses\RegistrationServices;

use Astrogoat\Courses\Models\Course;

abstract class RegistrationService
{
    public Course $course;
    public readonly array $service;

    abstract public function redirectUrl(): string;

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
