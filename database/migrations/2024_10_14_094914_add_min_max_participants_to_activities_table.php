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
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('min_participants')->default(2); // Minimum participants with default of 2
            $table->integer('max_participants')->default(1000); // Maximum participants with default of 1000
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('min_participants');
            $table->dropColumn('max_participants');
        });
    }
};
