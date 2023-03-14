<?php

namespace Astrogoat\Courses\Http\Livewire\Models\Courses;

use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\RegistrationServices\RegistrationServiceManager;
use Helix\Lego\Http\Livewire\Traits\CanBePublished;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Footer;
use Helix\Lego\Rules\SlugRule;

class Form extends \Helix\Lego\Http\Livewire\Models\Form
{
    use CanBePublished;

    public string $registration_service_provider = 'null';

    protected $listeners = [
        'updateRegistrationService',
    ];

    public function rules(): array
    {
        return [
            'model.title' => ['required'],
            'model.description' => ['nullable'],
            'model.wait_list_enabled' => ['boolean', 'nullable'],
            'model.is_open_for_registration' => ['boolean', 'nullable'],
            'model.meta.description' => ['nullable'],
            'model.slug' => [new SlugRule($this->model)],
            'model.indexable' => ['boolean'],
            'model.published_at' => ['nullable'],
            'registration_service_provider' => ['required'],
            'model.registration_service' => ['required'],
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
            $this->model->is_open_for_registration = is_null($this->model->is_open_for_registration) ? false : $this->model->is_open_for_registration;
            $this->model->wait_list_enabled = is_null($this->model->wait_list_enabled) ? false : $this->model->wait_list_enabled;
        }

        if (! isset($this->model->registration_service['provider'])) {
            $this->model->registration_service = ['provider' => array_key_first($this->registrationServices())];
        }

        $this->registration_service_provider = $this->model->registration_service['provider'];
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

    public function registrationServices(): array
    {
        return [
            'null' => 'None',
            'stripe-checkout' => 'Stripe Checkout',
            'stripe-payment-link' => 'Stripe Payment Link',
        ];
    }

    public function updatedRegistrationServiceProvider($value)
    {
        $this->model['registration_service'] = ['provider' => $value];

        $this->markAsDirty();
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

    public function registrationServiceHasOptionsComponent(): bool
    {
        return ! blank($this->getRegistrationServiceOptionsComponent());
    }

    public function getRegistrationServiceOptionsComponent(): ?string
    {
        return app(RegistrationServiceManager::class)
            ->driver($this->model['registration_service']['provider'] ?? 'null')
            ->setCourse($this->model)
            ->setService($this->model['registration_service'] ?? [])
            ->formOptionsComponent();
    }
}
