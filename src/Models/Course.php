<?php

namespace Astrogoat\Courses\Models;

use Astrogoat\Courses\Database\Factories\CourseFactory;
use Astrogoat\Courses\RegistrationServices\RegistrationServiceManager;
use Helix\Fabrick\Icon;
use Helix\Lego\Bricks\ValueObjects\LinkValueObject;
use Helix\Lego\Media\HasMedia;
use Helix\Lego\Media\Mediable;
use Helix\Lego\Models\Contracts\Indexable;
use Helix\Lego\Models\Contracts\Metafieldable;
use Helix\Lego\Models\Contracts\Publishable;
use Helix\Lego\Models\Contracts\Sectionable;
use Helix\Lego\Models\Model;
use Helix\Lego\Models\Traits\CanBePublished;
use Helix\Lego\Models\Traits\HasFooter;
use Helix\Lego\Models\Traits\HasMetafields;
use Helix\Lego\Models\Traits\HasSections;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model implements Indexable, Publishable, Sectionable, Mediable, Metafieldable
{
    use HasSlug;
    use HasMedia;
    use HasSections;
    use CanBePublished;
    use HasMetafields;
    use HasFactory;
    use HasFooter;

    protected $casts = [
        'wait_list_enabled' => 'boolean',
        'is_open_for_registration' => 'boolean',
        'registration_service' => 'json',
    ];

    protected $dates = [
        'started_at',
        'ended_at',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CourseFactory
    {
        return CourseFactory::new();
    }

    public static function getDisplayKeyName(): string
    {
        return 'title';
    }

    public static function icon(): string
    {
        return Icon::BOOK_OPEN;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(static::getDisplayKeyName())
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function waitListSignUp(string $email, string $name = null, Carbon $addedAt = null): Participant|EloquentModel
    {
        return $this->participants()->create([
            'email' => $email,
            'name' => $name,
            'wait_listed_at' => $addedAt ?: now(),
        ]);
    }

    public function shouldIndex(): bool
    {
        return $this->indexable;
    }

    public function getIndexedRoute(): string
    {
        return $this->getPublishedRoute();
    }

    public function getPublishedRoute(): string
    {
        return route('courses.show', $this);
    }

    public function editorShowViewRoute(string $layout = null): string
    {
        return route('lego.courses.editor', [
            'course' => $this,
            'editor_view' => 'show',
            'layout' => $layout,
        ]);
    }

    public function isFull(): bool
    {
        if (blank($this->max_participants)) {
            return false;
        }

        return $this->participants->count() >= $this->max_participants;
    }

    public function hasWaitList(): bool
    {
        return $this->wait_list_enabled === true;
    }

    public function isOngoing(): bool
    {
        if (blank($this->started_at)) {
            return false;
        }

        if ($this->started_at->isPast() && $this->ended_at->isFuture()) {
            return true;
        }

        return false;
    }

    public function hasEnded(): bool
    {
        if (blank($this->ended_at)) {
            return false;
        }

        return $this->ended_at->isPast();
    }

    public function allowRegistration(): bool
    {
        return $this->is_open_for_registration;
    }

    public function availabilityText(): string
    {
        return match (true) {
            $this->hasEnded() => 'Has ended',
            $this->isOngoing() => 'Has already started',
            $this->isFull() && ! $this->hasWaitList() => 'Sold out',
            $this->isFull() && $this->hasWaitList() => 'Sign up for wait list (Sold out)',
            $this->allowRegistration() => 'Register',
            $this->hasWaitList() => 'Notify me when available',
            ! $this->hasWaitList() => 'Coming soon',
        };
    }

    public function signupActionIsAvailable(): bool
    {
        return match (true) {
            $this->hasEnded() => false,
            $this->isOngoing() => false,
            $this->isFull() && ! $this->hasWaitList() => false,
            $this->isFull() && $this->hasWaitList() => true,
            $this->allowRegistration() => true,
            $this->hasWaitList() => true,
            ! $this->hasWaitList() => false,
        };
    }

    public function signUpLink(): LinkValueObject
    {
        $service = app(RegistrationServiceManager::class)
            ->driver($this->registration_service['provider'] ?? 'null')
            ->setService($this->registration_service ?? []);

        return new LinkValueObject([
            'href' => $service->redirectUrl(),
            'text' => $this->availabilityText(),
            'target' => '_blank',
        ]);
    }
}
