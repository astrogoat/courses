<?php

namespace Astrogoat\Courses\RegistrationServices;

use Astrogoat\Courses\Enums\SignUpStatus;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;

class StripeCheckoutDriver extends RegistrationService
{
    public function redirectUrl(): string
    {
        return route('courses.stripe.checkout', $this->course);
    }

    public function formOptionsComponent(): ?string
    {
        return 'astrogoat.courses.http.livewire.registrations-services.stripe-checkout.form';
    }

    public function signup(Participant $participant, Course $course): SignUpStatus
    {
        redirect()->route('courses.stripe.checkout', [
            'course' => $this->course,
            'participant' => $participant,
        ]);

        return SignUpStatus::REDIRECTED;
    }
}
