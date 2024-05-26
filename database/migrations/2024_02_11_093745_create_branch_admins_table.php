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
        Schema::create('branch_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('business_branches')->onDelete('cascade');
//            Name , email, password, phone
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->unique(['phone_code', 'phone']);
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
        Schema::dropIfExists('branch_admins');
    }
};
