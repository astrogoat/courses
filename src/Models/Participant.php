<?php

namespace Astrogoat\Courses\Models;

use Astrogoat\Courses\Database\Factories\CourseParticipantsFactory;
use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;

class Participant extends Model
{
    use Billable;
    use HasFactory;
    use HasUuids;

    protected $table = 'course_participants';

    protected $casts = [
        'pending_at' => 'datetime',
        'registered_at' => 'datetime',
        'wait_listed_at' => 'datetime',
    ];

    public static function booted(): void
    {
        //        static::addGlobalScope(new NotPending);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CourseParticipantsFactory
    {
        return CourseParticipantsFactory::new();
    }

    public function scopePending(Builder $query)
    {
        $query->whereNotNull('pending_at');
    }

    public function scopeRegistered(Builder $query)
    {
        $query->whereNotNull('registered_at');
    }

    public function scopeOnWaitList(Builder $query)
    {
        $query->whereNotNull('wait_listed_at');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function pending(string $email, string $name, Course $course): Participant
    {
        /** @var Participant $participant */
        $participant = static::make([
            'email' => $email,
            'name' => $name,
            'pending_at' => now(),
        ]);

        $course->participants()->save($participant);

        return $participant;
    }

    public function completeSignup(Carbon $registeredAt = null): static
    {
        $this->update([
            'pending_at' => null,
            'registered_at' => $registeredAt ?: ($this->registered_at ?: now()),
        ]);

        return $this;
    }

    public function getDisplayKeyName(): string
    {
        return 'name';
    }

    public static function icon(): string
    {
        return Icon::USER;
    }
}
