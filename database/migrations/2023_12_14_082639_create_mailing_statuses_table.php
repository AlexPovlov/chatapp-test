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
        Schema::create('mailing_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mailing_id')->constrained('mailings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('phone_id')->constrained('phones')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailing_statuses');
    }
};
