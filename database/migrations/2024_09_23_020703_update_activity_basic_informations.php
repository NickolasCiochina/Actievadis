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
            $table->string('location'); // Location of the activity
            $table->boolean('food_and_drinks_available'); // Availability of food and drinks
            $table->text('description'); // Description of the activity
            $table->dateTime('start_date')->nullable(); // Start date and time of the activity, allow NULL
            $table->dateTime('end_date')->nullable(); // End date and time of the activity, allow NULL
            $table->decimal('cost', 8, 2); // Cost of the activity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('food_and_drinks_available');
            $table->dropColumn('description');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('cost');
        });
    }
};
