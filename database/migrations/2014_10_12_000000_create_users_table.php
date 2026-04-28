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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email');
            $table->integer('role');
            $table->integer('emp_id')->nullable()->default(0);
            $table->string('username', 50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('department');
            $table->integer('designation');
            $table->string('mobile', 10)->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->text('picture')->nullable();
            $table->text('permission_array')->nullable();
            $table->text('permission')->nullable();
            $table->integer('status')->default(1);
            $table->enum('trash', ['NO', 'YES'])->default('NO');
            $table->rememberToken();
            $table->integer('created_at');
            $table->integer('updated_at')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();


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
