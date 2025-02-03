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
        Schema::create('banner_details', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->date('effective_date');
            $table->string('mbsize');
            $table->string('cbsize');
            $table->text('description_one');
            $table->text('description_two');
            $table->text('description_three');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('banner_details');
    }
};