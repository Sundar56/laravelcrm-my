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
        Schema::create('san_shop_languages_delivery', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('language_id');
            $table->string('shortname', 200)->default('')->comment('E.g. postdanmark');
            $table->integer('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_shop_languages_delivery');
    }
};
