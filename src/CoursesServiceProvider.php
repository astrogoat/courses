<?php

namespace Astrogoat\Courses;

use Astrogoat\Courses\Http\Livewire\Models\Courses\Form;
use Astrogoat\Courses\Http\Livewire\Models\Courses\Index;
use Astrogoat\Courses\Http\Livewire\Models\Courses\Partials\Participants;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;
use Astrogoat\Courses\Providers\EventServiceProvider;
use Astrogoat\Courses\Settings\CoursesSettings;
use Helix\Fabrick\Icon;
use Helix\Lego\Apps\App;
use Helix\Lego\LegoManager;
use Helix\Lego\Menus\Lego\Group;
use Helix\Lego\Menus\Lego\Link;
use Helix\Lego\Menus\Menu;
use Laravel\Cashier\Cashier;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CoursesServiceProvider extends PackageServiceProvider
{
    public function registerApp(App $app)
    {
        return $app
            ->name('courses')
            ->settings(CoursesSettings::class)
            ->migrations([
                __DIR__ . '/../database/migrations',
                __DIR__ . '/../database/migrations/settings',
            ])
            ->models([
                Course::class,
                Participant::class,
            ])
            ->menu(function (Menu $menu) {
                $menu->addToSection(
                    Menu::MAIN_SECTIONS['PRIMARY'],
                    Group::add(
                        'Courses',
                        [
                            Link::to(route('lego.courses.index'), 'Courses'),
                            Link::to(route('lego.courses.create'), 'Create new course'),
                        ],
                        Icon::BOOK_OPEN,
                    )->after('Pages')
                );
            })
            ->backendRoutes(__DIR__.'/../routes/backend.php')
            ->frontendRoutes(__DIR__.'/../routes/frontend.php')
            ->publishOnInstall([
                'courses-assets',
            ]);
    }

    public function registeringPackage()
    {
        $this->app->register(EventServiceProvider::class);
        Cashier::ignoreMigrations();

        $this->callAfterResolving('lego', function (LegoManager $lego) {
            $lego->registerApp(fn (App $app) => $this->registerApp($app));
        });
    }

    public function bootingPackage()
    {
        if ($this->app->runningInConsole()) {
            $this->publishFiles();
        }

        Livewire::component('astrogoat.courses.http.livewire.models.courses.index', Index::class);
        Livewire::component('astrogoat.courses.http.livewire.models.courses.form', Form::class);
        Livewire::component('astrogoat.courses.http.livewire.models.courses.partials.participants', Participants::class);
        Livewire::component('astrogoat.courses.http.livewire.registrations-services.stripe-checkout.form', \Astrogoat\Courses\Http\Livewire\RegistrationServices\StripeCheckout\Courses\Form::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('courses')->hasConfigFile()->hasViews();
    }

    private function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/courses/'),
        ], 'courses-assets');
    }
}
