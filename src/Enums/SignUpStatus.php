<?php

namespace Astrogoat\Courses\Enums;

enum SignUpStatus: string
{
    case PENDING = 'pending';
    case REDIRECTED = 'redirected';
    case REGISTERED = 'registered';
    case CANCELED = 'canceled';
    case ADDED_TO_WAIT_LIST = 'added to wait list';
}
