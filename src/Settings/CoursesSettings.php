<?php

namespace Astrogoat\Courses\Settings;

use Astrogoat\Courses\Actions\CoursesAction;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class CoursesSettings extends AppSettings
{
    // public string $url;

    public function rules(): array
    {
        return [
            // 'url' => Rule::requiredIf($this->enabled === true),
        ];
    }

    // protected static array $actions = [
    //     CoursesAction::class,
    // ];

    // public static function encrypted(): array
    // {
    //     return ['access_token'];
    // }

    public function description(): string
    {
        return 'Interact with Courses.';
    }

    public static function group(): string
    {
        return 'courses';
    }
}
