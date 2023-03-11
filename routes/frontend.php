<?php

use Astrogoat\Courses\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;

Route::get('courses/{course:slug}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('courses/confirmation/{checkoutConfirmationId}', [CoursesController::class, 'update'])->name('courses.update');
