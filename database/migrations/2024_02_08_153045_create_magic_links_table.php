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
        Schema::create('magic_links', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->dateTime('requested_at');
            $table->datetime('expires_at');
            $table->datetime('authenticated_at')->nullable();
            $table->ipAddress('ip_requested_from');
            $table->ipAddress('ip_authentication_from')->nullable();
            $table->string('intended_url', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magic_links');
    }
};
