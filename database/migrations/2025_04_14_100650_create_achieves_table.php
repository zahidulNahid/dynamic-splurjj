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
        Schema::create('achieves', function (Blueprint $table) {
            $table->id();
            $table->string('back_img')->nullable();
            $table->string('mbl_img1')->nullable();
            $table->string('mbl_img2')->nullable();
            $table->string('mbl_img3')->nullable();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('logo_img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achieves');
    }
};
