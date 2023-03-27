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
        Schema::create('notification_template', function (Blueprint $table) {
            $table->char('id', 36);
            $table->string('template_name', 255);
            $table->string('template_title', 255);
            $table->text('template_content');
            $table->integer('region_id')->nullable();
            $table->integer('area_id')->nullable();
            $table->integer('industry_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_template');
    }
};
