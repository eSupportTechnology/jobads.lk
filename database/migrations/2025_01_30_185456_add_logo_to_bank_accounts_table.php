<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('currency'); // Adding logo column
            $table->string('localorforeign')->after('logo');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('logo'); // Dropping logo column if rolled back
        });
    }
};