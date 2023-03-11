<?php

use Astrogoat\Courses\Http\Controllers\CourseStripeCheckoutController;
use Astrogoat\Courses\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::get('courses/{course:slug}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('courses/confirmation/{checkoutConfirmationId}', [CoursesController::class, 'update'])->name('courses.update');

//Route::get('payment/{id}', 'PaymentController@show')->name('payment');
Route::post('courses/webhooks/stripe', [WebhookController::class, 'handleWebhook']);

Route::get('courses/{course:slug}/stripe/checkout', CourseStripeCheckoutController::class)->name('courses.stripe.checkout');
