<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learning_logs', function (Blueprint $table) {
            $table->index(['id_user', 'id_material'], 'learning_logs_user_material_idx');
        });
    }

    public function down(): void
    {
        Schema::table('learning_logs', function (Blueprint $table) {
            $table->dropIndex('learning_logs_user_material_idx');
        });
    }
};
