<?php

namespace Astrogoat\Courses\RegistrationServices;

abstract class RegistrationService
{
    public readonly array $service;

    abstract public function redirectUrl(): string;

    public function setService(array $service): static
    {
        $this->service = $service;

        return $this;
    }
}
