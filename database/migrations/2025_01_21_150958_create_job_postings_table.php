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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->text('description');
        $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
        $table->foreignId('subcategory_id')->constrained('subcategories')->cascadeOnDelete();
        $table->string('location');
        $table->string('country')->nullable();
        $table->decimal('salary_range', 10, 2)->nullable();
        $table->string('image')->nullable();
        $table->text('requirements')->nullable();
        $table->foreignId('employer_id')->nullable()->constrained('employers')->nullOnDelete();
        $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
        $table->foreignId('creator_id')->nullable()->constrained('admins')->cascadeOnDelete();
        $table->date('closing_date');
        $table->dateTime('approved_date')->nullable();
        $table->dateTime('rejected_date')->nullable();
        $table->string('status')->default('pending');
        $table->string('payment_method')->nullable();
        $table->string('rejection_reason')->nullable();
        $table->string('job_id')->index();
        $table->boolean('is_active')->default(true);
        $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
        $table->unsignedBigInteger('view_count')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
