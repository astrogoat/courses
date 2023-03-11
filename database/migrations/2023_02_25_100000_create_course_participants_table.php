<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_participants', function (Blueprint $table) {
            $table->id();

            $table->string('email');
            $table->string('name')->nullable();

            $table->foreignId('course_id')->constrained()->onDelete('cascade');

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
