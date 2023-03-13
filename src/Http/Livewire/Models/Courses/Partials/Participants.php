<?php

namespace Astrogoat\Courses\Http\Livewire\Models\Courses\Partials;

use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;
use Livewire\Component;

class Participants extends Component
{
    public Course $course;
    public $view = 'registered';

    public function participants(string $view = null)
    {
        return match ($view ?: $this->view) {
            'registered' => $this->course->participants()->registered()->orderBy('name')->paginate(8),
            'waitList' => $this->course->participants()->onWaitList()->orderBy('name')->paginate(8),
            'abandoned' => $this->course->participants()->pending()->orderBy('name')->paginate(8),
        };
    }

    public function dateColumnHeader(): string
    {
        return match ($this->view) {
            'registered' => 'Registered on',
            'waitList' => 'Wait listed on',
            'abandoned' => 'Attempted on',
        };
    }

    public function dateColumn(Participant $participant): string
    {
        return match ($this->view) {
            'registered' => $participant->registered_at?->toDayDateTimeString(),
            'waitList' => $participant->wait_listed_at?->toDayDateTimeString(),
            'abandoned' => $participant->pending_at?->toDayDateTimeString(),
        };
    }

    public function render()
    {
        return view('courses::models.courses.partials.participants');
    }
}
