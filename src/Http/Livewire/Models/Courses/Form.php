<?php

namespace Astrogoat\Courses\Http\Livewire\Models\Courses;

use Astrogoat\Courses\Models\Course;
use Helix\Lego\Http\Livewire\Traits\CanBePublished;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Footer;
use Helix\Lego\Rules\SlugRule;

class Form extends \Helix\Lego\Http\Livewire\Models\Form
{
    use CanBePublished;

    public string $signUpProvider = 'default';

    protected $listeners = [
        'updateRegistrationService',
    ];

    public function rules(): array
    {
        return [
            'model.title' => ['required'],
            'model.description' => ['nullable'],
            'model.wait_list_enabled' => ['boolean'],
            'model.is_open_for_registration' => ['boolean'],
//            'model.meta.description' => ['nullable'],
            'model.slug' => [new SlugRule($this->model)],
            'model.registration_service' => ['required'],
//            'model.registration_service.provider' => ['required'],
//            'model.registration_service.link' => ['nullable'],
//            'model.registration_service.price_id' => ['nullable'],
        ];
    }

    public function model(): string
    {
        return Course::class;
    }

    public function mount($course = null)
    {
        $this->setModel($course);

        if (! $this->model->exists) {
            $this->model->indexable = true;
            $this->model->layout = array_key_first(siteLayouts());
        }

        if (! isset($this->model->registration_service['provider'])) {
            $this->model->registration_service = ['provider' => array_key_first($this->registrationServices())];
        }
    }

    public function footers()
    {
        return Footer::all()->pluck('title', 'id');
    }

    public function view(): string
    {
        return 'courses::models.courses.form';
    }

    public function getPublishableModel(): Publishable
    {
        return $this->model;
    }

    public function participants()
    {
        return $this->model->participants()->orderBy('name')->paginate(8);
    }

    public function registrationServices(): array
    {
        return [
            'custom' => 'Custom',
            'stripe-checkout' => 'Stripe Checkout',
            'stripe-payment-link' => 'Stripe Payment Link',
        ];
    }

    public function updateRegistrationService($payload)
    {
        $registrationService = $this->model->registration_service;

        foreach ($payload as $key => $value) {
            data_set($registrationService, $key, $value);
        }

        $this->model['registration_service'] = $registrationService;

        $this->markAsDirty();
    }
}
