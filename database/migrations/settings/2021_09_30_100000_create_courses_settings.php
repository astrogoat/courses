<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateCoursesSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('courses.enabled', false);
        // $this->migrator->add('courses.url', '');
        // $this->migrator->addEncrypted('courses.access_token', '');
    }

    public function down()
    {
        $this->migrator->delete('courses.enabled');
        // $this->migrator->delete('courses.url');
        // $this->migrator->delete('courses.access_token');
    }
}
