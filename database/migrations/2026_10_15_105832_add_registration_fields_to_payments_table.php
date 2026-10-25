<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'full_name')) {
                $table->string('full_name')->after('user_id');
            }
            if (!Schema::hasColumn('payments', 'phone')) {
                $table->string('phone')->after('full_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'full_name')) $table->dropColumn('full_name');
            if (Schema::hasColumn('payments', 'phone')) $table->dropColumn('phone');
        });
    }
};
