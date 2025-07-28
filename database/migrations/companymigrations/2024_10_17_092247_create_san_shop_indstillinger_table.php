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
        Schema::create('san_shop_indstillinger', function (Blueprint $table) {
            $table->increments('id');
            $table->text('beskrivelse')->nullable();
            $table->text('funktion1')->nullable();
            $table->text('funktion2')->nullable();
            $table->text('funktion3')->nullable();
            $table->text('funktion4')->nullable();
            $table->text('funktion5')->nullable();
            $table->text('funktion6')->nullable();
            $table->text('navn')->nullable();
            $table->integer('language_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_shop_indstillinger');
    }
};
