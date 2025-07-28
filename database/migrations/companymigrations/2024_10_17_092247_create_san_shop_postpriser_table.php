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
        Schema::create('san_shop_postpriser', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transporttype', 100)->nullable();
            $table->text('navn')->nullable();
            $table->text('vaegt')->nullable();
            $table->text('type')->nullable();
            $table->text('sendetype')->nullable();
            $table->text('pris')->nullable();
            $table->text('efterkrav')->nullable();
            $table->text('vaegt_start')->nullable();
            $table->text('vaegt_slut')->nullable();
            $table->integer('language_id')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_shop_postpriser');
    }
};
