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
        Schema::create('business_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            /**
             * if the branches is in different countries, we can add a country_id here
             * or any other columns related to countries and cities
             */
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('business_branch_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_branch_id')->constrained('business_branches')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['business_branch_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_branches');
    }
};
