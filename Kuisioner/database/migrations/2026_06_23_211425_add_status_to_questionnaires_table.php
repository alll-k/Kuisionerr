<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            // Menambahkan status Draft, Published, atau Closed
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft')->after('description');
        });
    }

    public function down()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};