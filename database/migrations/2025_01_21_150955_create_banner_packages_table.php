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
        Schema::create('banner_packages', function (Blueprint $table) {
            $table->id();
            $table->string('duration')->default('7days');
            $table->decimal('price_lkr', 10, 2)->default(0.00);
            $table->decimal('price_usd', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_packages');
    }
};
