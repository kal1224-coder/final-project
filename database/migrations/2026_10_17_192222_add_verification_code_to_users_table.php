<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'verification_code')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('verification_code', 4)->nullable()->after('email');
            });
        }
        if (!Schema::hasColumn('users', 'is_verified')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_verified')->default(false)->after('verification_code');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'verification_code')) $table->dropColumn('verification_code');
            if (Schema::hasColumn('users', 'is_verified')) $table->dropColumn('is_verified');
        });
    }
};
