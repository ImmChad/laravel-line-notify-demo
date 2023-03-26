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
        Schema::create('notification_user_info', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('displayName', 255);
            $table->text('pictureUrl');
            $table->string('phone_number', 15);
            $table->string('password', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_user_info');
    }
};
