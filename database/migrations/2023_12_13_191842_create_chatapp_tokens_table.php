<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chatapp_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->text('access_token');
            $table->text('refresh_token');
            $table->bigInteger('access_token_end_time');
            $table->bigInteger('refresh_token_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatapp_tokens');
    }
};
