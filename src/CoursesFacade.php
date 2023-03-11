<?php

namespace Astrogoat\Courses;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Astrogoat\Courses\Courses
 */
class CoursesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'courses';
    }
}
