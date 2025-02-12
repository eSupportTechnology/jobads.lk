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
        Schema::create('package_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->date('effective_date');
            $table->text('description_one');
            $table->text('description_two');
            $table->text('description_three');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('package_contacts');
    }
};