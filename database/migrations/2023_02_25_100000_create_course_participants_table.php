<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_participants', function (Blueprint $table) {
            $table->uuid('id');

            $table->string('email');
            $table->string('name')->nullable();

            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            $table->timestamp('pending_at')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('wait_listed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_participants');
    }
};
