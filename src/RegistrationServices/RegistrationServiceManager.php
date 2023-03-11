<?php

namespace Astrogoat\Courses\RegistrationServices;

use Illuminate\Support\Manager;

class RegistrationServiceManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'stripe-payment-link';
    }

    public function createStripePaymentLinkDriver(): StripePaymentLinkDriver
    {
        return new StripePaymentLinkDriver();
    }

    public function createNullDriver(): NullDriver
    {
        return new NullDriver();
    }
}
