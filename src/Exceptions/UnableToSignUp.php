<?php

namespace Astrogoat\Courses\Exceptions;

use Astrogoat\Courses\Models\Course;
use Exception;

class UnableToSignUp extends Exception
{
    public static function courseNotAvailableForSignUps(Course $course): static
    {
        return new static('Course "' . $course->title . '" is not available for sign ups. ' . $course->availabilityText());
    }
}
