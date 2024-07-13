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
            $table->string('phone')->after('password');
            $table->integer('login_code')->after('phone')->nullable();
            $table->timestamp('last_login_attempt')->after('login_code')->nullable();
            $table->integer('user_type')->after('last_login_attempt');
            $table->string('govt_issued_id')->nullable()->after('user_type');
            $table->integer('status')->nullable();
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
