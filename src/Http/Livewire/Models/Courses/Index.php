<?php

namespace Astrogoat\Courses\Http\Livewire\Models\Courses;

use Astrogoat\Courses\Models\Course;

class Index extends \Helix\Lego\Http\Livewire\Models\Index
{
    public function model(): string
    {
        return Course::class;
    }

    public function columns(): array
    {
        return [
            'title' => 'Title',
            'started_at' => 'Start Date',
            'ended_at' => 'End Date',
            'participants' => 'Sign Ups',
        ];
    }

    public function mainSearchColumn(): string|false
    {
        return 'title';
    }

    public function courseStatusColor(Course $course): string
    {
        return match (true) {
            $course->isFull() || $course->hasEnded() || $course->isOngoing() => 'bg-red-400',
            default => 'bg-gray-200'
        };
    }

    public function render()
    {
        return view('courses::models.courses.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
