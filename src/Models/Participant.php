<?php

namespace Astrogoat\Courses\Models;

use Astrogoat\Courses\Database\Factories\CourseParticipantsFactory;
use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'course_participants';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CourseParticipantsFactory
    {
        return CourseParticipantsFactory::new();
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
