<?php

namespace Astrogoat\Courses\RegistrationServices;

class StripePaymentLinkDriver extends RegistrationService
{
    public function redirectUrl(): string
    {
        return $this->service['link'];
    }

    public function formOptionsComponent(): ?string
    {
        return null;
    }
}
