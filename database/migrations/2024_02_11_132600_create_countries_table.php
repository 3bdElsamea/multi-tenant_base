<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 2)->unique(); // example: EG, US, DE
            $table->string('phone_code', 5)->unique(); // example: 20, 1, 49
            $table->string('currency_code', 3)->unique(); // example: EGP, USD, EUR
            $table->string('currency_symbol', 5)->nullable(); // example: E£, $, € 
//            $table->string('currency_name')->nullable();
            $table->string('phone_limit')->nullable();
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
