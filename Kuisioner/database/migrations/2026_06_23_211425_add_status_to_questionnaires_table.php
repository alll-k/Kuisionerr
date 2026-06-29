<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('questionnaires', 'status')) {
            Schema::table('questionnaires', function (Blueprint $table) {
                // Menambahkan status Draft, Published, atau Closed jika belum ada
                $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            });
        }
    }

    public function down()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
