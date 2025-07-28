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
        Schema::create('nyhedsbrev_tilmeldte', function (Blueprint $table) {
            $table->increments('id');
            $table->text('email')->nullable();
            $table->text('tilmeldnings_dato')->nullable();
            $table->text('fra_site')->nullable()->comment('Kommer denne nyhedsbrevstilmeldning fra wifishop, JDS eller hvor???');
            $table->string('navn', 55)->nullable()->default('');
            $table->boolean('inactive')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nyhedsbrev_tilmeldte');
    }
};
