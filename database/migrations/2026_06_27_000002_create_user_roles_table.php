<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create user_roles table
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // 2. Seed default roles
        DB::table('user_roles')->insert([
            ['id' => 1, 'name' => 'user', 'description' => 'Regular customer. Can submit and view their own tickets.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'agent', 'description' => 'Support team member. Can be assigned tickets but has no admin console access.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'admin', 'description' => 'Full admin access. Can manage all tickets, users, and settings.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Add role_id to users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('password');
        });

        // 4. Migrate string roles to integer role_ids
        DB::statement("UPDATE users SET role_id = CASE 
            WHEN role = 'admin' THEN 3 
            WHEN role = 'agent' THEN 2 
            ELSE 1 
        END");

        // 5. Drop role column and add foreign key
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->default(1)->nullable(false)->change();
            $table->dropColumn('role');
            $table->foreign('role_id')->references('id')->on('user_roles');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->string('role')->default('user')->after('password');
        });

        DB::statement("UPDATE users SET role = CASE 
            WHEN role_id = 3 THEN 'admin' 
            WHEN role_id = 2 THEN 'agent' 
            ELSE 'user' 
        END");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('user_roles');
    }
};
