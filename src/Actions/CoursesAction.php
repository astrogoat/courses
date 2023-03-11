<?php

namespace Astrogoat\Courses\Actions;

use Helix\Lego\Apps\Actions\Action;

class CoursesAction extends Action
{
    public static function actionName(): string
    {
        return 'Courses action name';
    }

    public static function run(): mixed
    {
        return redirect()->back();
    }
}
