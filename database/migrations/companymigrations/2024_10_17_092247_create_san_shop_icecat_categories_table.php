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
        Schema::create('san_shop_icecat_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('categoryfeaturegroup_id')->nullable()->default(0);
            $table->text('navn_da')->nullable();
            $table->unsignedTinyInteger('opdateret')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_shop_icecat_categories');
    }
};
