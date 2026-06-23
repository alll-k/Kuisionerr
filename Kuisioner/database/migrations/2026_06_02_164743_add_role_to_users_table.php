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
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('nisn_npm')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // SQLite doesn't support dropping foreign keys directly
            // We'll just drop the columns
            $table->dropColumn(['role_id', 'nisn_npm', 'phone', 'faculty', 'department']);
        });
    }
};
