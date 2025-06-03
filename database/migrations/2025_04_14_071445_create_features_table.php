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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('mbl_img1')->nullable();
            $table->string('mbl_img2')->nullable();
            $table->string('mbl_img3')->nullable();
            $table->string('mbl_img4')->nullable();
            $table->string('title1')->nullable();
            $table->text('all_mbl_img')->nullable(); // assuming this might be a comma-separated list or JSON
            $table->string('title2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
