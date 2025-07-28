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
        Schema::create('san_shop_links', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('page_identifier', 55)->nullable()->default('');
            $table->string('link_label', 100)->nullable()->default('');
            $table->string('link_destination', 200)->nullable()->default('');
            $table->integer('order')->nullable()->default(0);
            $table->integer('language_id')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_shop_links');
    }
};
