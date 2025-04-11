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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('iso2')->nullable();
            $table->string('iso3')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('capital')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('region')->nullable();
            $table->string('subregion')->nullable();
            $table->string('native')->nullable();
            $table->string('language')->nullable();
            $table->string('nationality')->nullable();
            $table->string('time_zone_name')->nullable();
            $table->string('gmt_offset')->nullable();
            $table->string('gmt_offset_name')->nullable();
            $table->string('abbreviation')->nullable();
            $table->string('tz_name')->nullable();
            $table->string('emoji')->nullable();
            $table->string('emojiU')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
