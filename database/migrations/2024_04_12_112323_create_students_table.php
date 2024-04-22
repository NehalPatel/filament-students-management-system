<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stream_id')->constrained('streams');
            $table->foreignId('division_id')->constrained('divisions');
            $table->string('name');
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('spdid', 20)->nullable();
            $table->string('enrollment_no', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 20)->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};