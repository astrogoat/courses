<?php

namespace Astrogoat\Courses\Bricks;

use Astrogoat\Courses\Models\Course as CourseModel;
use Helix\Lego\Bricks\Brick;

class Course extends Brick
{
    public function coursesOptions(): array
    {
        return CourseModel::all()->pluck('title', 'id')->toArray();
    }

    public function brickView(): string
    {
        return 'courses::bricks.course';
    }
}
