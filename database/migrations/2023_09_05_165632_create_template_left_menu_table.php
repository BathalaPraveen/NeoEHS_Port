<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_left_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('namekey')->nullable();
            $table->string('link')->nullable();
            $table->string('icon')->nullable();
            $table->integer('parent_id');
            $table->integer('is_parent');
            $table->enum('is_module', ['0', '1']);
            $table->string('modkey');
            $table->integer('sort_order');
            $table->dateTime('created')->useCurrent();
            $table->dateTime('updated')->useCurrent();
            $table->integer('status')->default(1);
            $table->enum('trash', ['NO', 'YES'])->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_left_menu');
    }
};
