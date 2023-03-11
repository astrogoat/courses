<?php

namespace Astrogoat\Courses\RegistrationServices;

class StripeCheckoutDriver extends RegistrationService
{
    public function redirectUrl(): string
    {
        return route('courses.stripe.checkout', $this->course);
    }
}
