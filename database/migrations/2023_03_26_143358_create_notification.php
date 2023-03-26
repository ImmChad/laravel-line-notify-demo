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
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('announce_title', 255);
            $table->text('announce_content');
            $table->dateTime('created_at');
            $table->binary('is_sent');
            $table->binary('is_scheduled');
            $table->timestamps('scheduled_at');
            $table->timestamps('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
