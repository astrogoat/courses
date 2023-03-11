<?php

namespace Astrogoat\Courses\Http\Livewire\RegistrationServices\StripeCheckout\Courses;

use Astrogoat\Courses\Models\Course;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Livewire\Component;

class Form extends Component
{
    public Course $course;

    public function rules(): array
    {
        return [
            'course.registration_service.price_id' => ['required'],
        ];
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

        dd(Cashier::stripe()->products->all(), Cashier::stripe()->prices->search([
            'query' => 'product:\'prod_NTjeovlPoA6b52\''
        ]));
        dd(Cashier::stripe()->products->all());
    }

    public function render()
    {
        return view('courses::registration-services.stripe-checkout.courses.form');
    }
}
