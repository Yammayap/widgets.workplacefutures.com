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
        Schema::create('space_calculator_inputs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->timestamps();
            $table->foreignId('enquiry_id')->references('id')->on('enquiries');
            $table->string('workstyle', 50);
            $table->integer('total_people');
            $table->integer('growth_percentage');
            $table->integer('desk_percentage');
            $table->string('hybrid_working', 50);
            $table->string('mobility', 50);
            $table->string('collaboration', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_calculator_inputs');
    }
};
