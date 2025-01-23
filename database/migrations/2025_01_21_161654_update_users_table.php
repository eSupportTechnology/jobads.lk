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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 20)->after('email')->nullable(); // Update existing columns or add new ones
            $table->string('resume_file')->nullable();
            $table->text('address')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('summary')->nullable();
            $table->text('experience')->nullable();
            $table->text('education')->nullable();
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->string('portfolio_link')->nullable();
            $table->text('social_links')->nullable();
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
