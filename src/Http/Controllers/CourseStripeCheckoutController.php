<?php

namespace Astrogoat\Courses\Http\Controllers;

use Astrogoat\Courses\Enums\SignUpStatus;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\Models\Participant;
use Astrogoat\Courses\Models\Scopes\NotPending;
use Astrogoat\Courses\RegistrationServices\StripeCheckoutDriver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Cashier\Cashier;
use Throwable;

class CourseStripeCheckoutController extends Controller
{
    /**
     * @throws Throwable
     */
    public function checkout(Request $request, Course $course)
    {
        $participant = Participant::withoutGlobalScope(NotPending::class)->where('id', $request->get('participant'))->firstOrFail();
        $registrationService = $course->getRegistrationService();

        throw_unless(
            $registrationService instanceof StripeCheckoutDriver,
            Exception::class,
            'Registration service is not Stripe Checkout'
        );

        throw_unless(isset($registrationService->service['price_id']), Exception::class, 'Price ID is missing for Stripe Checkout Service');

        if ($registrationService->service['allow_promotion_codes'] ?? false) {
            $participant->allowPromotionCodes();
        }

        return $participant->checkout($registrationService->service['price_id'], [
            'success_url' => route('courses.stripe.checkout.success', [
                'course' => $course,
                'participant' => $participant,
            ]).'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('courses.show', ['course' => $course, 'canceled' => true]),
        ]);
    }

    public function success(Request $request, Course $course)
    {
        $session = Cashier::stripe()->checkout->sessions->retrieve($request->get('session_id'));

        $participant = Participant::withoutGlobalScope(NotPending::class)
            ->where('id', $request->get('participant'))
            ->firstOrFail();

        if ($session->status === 'complete' && $session->payment_status === 'paid') {
            $participant->completeSignup();

            return redirect(route('courses.show', ['course' => $course, 'signup_status' => SignUpStatus::REGISTERED->value]));
        }

        //        dd($request->all(), $course, $session, $participant);

        return redirect(route('courses.show', ['course' => $course, 'signup_status' => 'failed']));
    }

    public function cancel(Request $request, Course $course)
    {
        dd($request->all(), $course);
    }
}
