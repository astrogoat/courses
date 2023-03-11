<?php

namespace Astrogoat\Courses\Commands;

use Illuminate\Console\Command;

class CoursesCommand extends Command
{
    public $signature = 'courses';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
