<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('announcements', 'note')) {
                $table->text('note')->after('title');
            }
            if (!Schema::hasColumn('announcements', 'image')) {
                $table->string('image')->nullable()->after('note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'title')) $table->dropColumn('title');
            if (Schema::hasColumn('announcements', 'note')) $table->dropColumn('note');
            if (Schema::hasColumn('announcements', 'image')) $table->dropColumn('image');
        });
    }
};
