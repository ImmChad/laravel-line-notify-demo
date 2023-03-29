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
        Schema::create('notification_draft', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification_for', 255);
            $table->string('notification_title', 255);
            $table->string('notification_content');
            $table->integer('area_id');
            $table->integer('industry_id');
            $table->integer('sms_user');
            $table->integer('line_user');
            $table->integer('mail_user');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_draft');
    }
};
