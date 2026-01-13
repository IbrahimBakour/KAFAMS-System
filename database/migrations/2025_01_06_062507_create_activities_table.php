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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); // Subject name like Adab, Bahasa Arab, Jawi
            $table->string('question'); // Quiz question
            $table->string('option_a'); // Option A
            $table->string('option_b'); // Option B
            $table->string('option_c'); // Option C
            $table->string('option_d'); // Option D
            $table->string('correct_option'); // Correct option (A, B, C, or D)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
