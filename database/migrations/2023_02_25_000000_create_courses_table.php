<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->json('meta')->nullable();
            $table->string('layout')->nullable();
            $table->string('location')->nullable();
            $table->integer('price')->nullable();
            $table->integer('min_participants')->nullable();
            $table->integer('max_participants')->nullable();
            $table->json('registration_service')->nullable();

            $table->boolean('indexable')->nullable();
            $table->boolean('is_open_for_registration')->default(true);
            $table->boolean('wait_list_enabled')->default(true);

            $table->timestamp('published_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
