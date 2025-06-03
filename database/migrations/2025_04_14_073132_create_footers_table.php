<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('logo')->nullable();
            $table->string('login_link')->nullable();
            $table->string('app_store_link')->nullable();
            $table->string('google_play_link')->nullable();
            $table->longText('first_text')->nullable();
            $table->string('first_text_color')->nullable();
            $table->longText('second_text')->nullable();
            $table->string('second_text_color')->nullable();
            $table->longText('third_text')->nullable();
            $table->string('third_text_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
