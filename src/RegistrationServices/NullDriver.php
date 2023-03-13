<?php

namespace Astrogoat\Courses\RegistrationServices;

use Astrogoat\Courses\Enums\SignUpStatus;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;

class NullDriver extends RegistrationService
{
    public function redirectUrl(): string
    {
        return '';
    }

    public function formOptionsComponent(): ?string
    {
        return null;
    }

    public function signup(Participant $participant, Course $course): SignUpStatus
    {
        $course->participants()->save($participant);

        return SignUpStatus::REGISTERED;
    }
}
