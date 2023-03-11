<?php

namespace Astrogoat\Courses\Http\Controllers;

use Astrogoat\Courses\Models\CashierUser;
use Astrogoat\Courses\Models\Course;
use Astrogoat\Courses\RegistrationServices\StripeCheckoutDriver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Throwable;

class CourseStripeCheckoutController extends Controller
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request, Course $course)
    {
        $user = new CashierUser($request->user());
        $registrationService = $course->getRegistrationService();

        throw_unless(
            $registrationService instanceof StripeCheckoutDriver,
            Exception::class,
            'Registration service is not Stripe Checkout'
        );

        throw_unless(isset($registrationService->service['price_id']), Exception::class, 'Price ID is missing for Stripe Checkout Service');

        return $user->allowPromotionCodes()
            ->checkout($registrationService->service['price_id']);
    }
}
