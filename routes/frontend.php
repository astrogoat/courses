<?php

use Astrogoat\Courses\Http\Controllers\CourseStripeCheckoutController;
use Astrogoat\Courses\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::group(['prefix' => 'courses'], function () {
    Route::get('{course:slug}', [CoursesController::class, 'show'])->name('courses.show');
    Route::get('confirmation/{checkoutConfirmationId}', [CoursesController::class, 'update'])->name('courses.update');

    //Route::get('payment/{id}', 'PaymentController@show')->name('payment');
    Route::post('webhooks/stripe', [WebhookController::class, 'handleWebhook']);

    Route::get('{course:slug}/stripe/checkout', [CourseStripeCheckoutController::class, 'checkout'])->name('courses.stripe.checkout');
    Route::get('{course:slug}/stripe/checkout/success', [CourseStripeCheckoutController::class, 'success'])->name('courses.stripe.checkout.success');
    Route::get('{course:slug}/stripe/checkout/cancel', [CourseStripeCheckoutController::class, 'cancel'])->name('courses.stripe.checkout.cancel');
});
