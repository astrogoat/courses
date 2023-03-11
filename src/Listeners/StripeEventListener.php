<?php

namespace Astrogoat\Courses\Listeners;

use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        Log::debug($event->payload['type'] . ' webhook received from Stripe.', ['event' => $event]);

        if ($event->payload['type'] === 'checkout.session.completed') {
            Log::debug('checkout.session.completed webhook from Stripe handled', ['event' => $event]);
        }
    }
}
