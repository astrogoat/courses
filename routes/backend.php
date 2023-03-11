<?php

use Astrogoat\Courses\Http\Controllers\CoursesController;
use Astrogoat\Courses\Http\Livewire\Models\Courses\Form;
use Astrogoat\Courses\Http\Livewire\Models\Courses\Index;
use Helix\Lego\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'courses.',
    'prefix' => 'courses',
], function () {
    Route::get('/', Index::class)->name('index');
    Route::get('create', Form::class)->name('create');
    Route::get('{course}/edit', Form::class)->name('edit');
    Route::get('{course}/editor/{editor_view?}', [CoursesController::class, 'editor'])->name('editor');
});
