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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('business_id')->nullable()->constrained('businesses')->cascadeOnDelete();
            $table->string('password');
//            Custom columns
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_type')->nullable();
            $table->boolean('is_active')->default(1);
//            $table->string('verification_code')->nullable();
//            $table->string('password_reset_code')->nullable();
//            $table->timestamp('password_reset_code_expire_at')->nullable();
//          Soft delete
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
