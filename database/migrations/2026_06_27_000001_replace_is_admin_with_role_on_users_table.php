<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
        });

        // Migrate existing is_admin data
        DB::statement("UPDATE users SET role = CASE WHEN is_admin = 1 THEN 'admin' ELSE 'user' END");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });

        DB::statement("UPDATE users SET is_admin = CASE WHEN role = 'admin' THEN 1 ELSE 0 END");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
