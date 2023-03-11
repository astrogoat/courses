<?php

namespace Astrogoat\Courses\RegistrationServices;

class NullDriver extends RegistrationService
{
    public function redirectUrl(): string
    {
        return request()->url();
    }
}
