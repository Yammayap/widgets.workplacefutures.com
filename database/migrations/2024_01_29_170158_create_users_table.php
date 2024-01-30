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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->timestamps();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 250)->unique();
            $table->string('company_name', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->boolean('marketing_opt_in')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
