<?php

namespace Astrogoat\Courses\Http\Livewire\RegistrationServices\StripeCheckout\Courses;

use Astrogoat\Courses\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Livewire\Component;
use Stripe\Price;

class Form extends Component
{
    public Course $course;

    public function rules(): array
    {
        return [
            'course.registration_service.price_id' => ['required'],
            'course.registration_service.allow_promotion_codes' => ['boolean'],
        ];
    }

    public function mount()
    {
        if (! isset($this->course->registration_service['price_id'])) {
            $service = $this->course->registration_service;
            data_set($service, 'price_id', array_key_first($this->getProducts()->toArray()));
            $this->course->registration_service = $service;
        }
    }

    public function updating($property, $value)
    {
        $this->emitTo(
            \Astrogoat\Courses\Http\Livewire\Models\Courses\Form::class,
            'updateRegistrationService',
            [Str::after($property, 'course.registration_service.') => $value]
        );
    }

    public function getProducts()
    {
        $prices = Cache::remember('stripe-prices', now()->addMinutes(5), fn () => Cashier::stripe()->prices->all()->data);
        $products = Cache::remember('stripe-products', now()->addMinutes(5), fn () => Cashier::stripe()->products->all()->data);

        return collect($prices)->mapWithKeys(function (Price $price) use ($products) {
            $product = collect($products)->where('id', $price->product)->sole();

            return [$price->id => $product->name . ' - $' . ($price->unit_amount / 100)];
        });
    }

    public function render()
    {
        return view('courses::registration-services.stripe-checkout.courses.form');
    }
}
