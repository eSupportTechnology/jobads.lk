<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banner_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duration_id')->constrained('duration')->onDelete('cascade');
            $table->decimal('price_lkr', 10, 2)->default(0);
            $table->decimal('price_usd', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_packages');
    }
};