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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('tenant', 9);
            $table->string('widget', 50);
            $table->text('message')->nullable();
            $table->boolean('can_contact')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
