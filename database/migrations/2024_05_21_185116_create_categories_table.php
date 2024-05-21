<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing integer primary key
            $table->string('name', 255)->nullable(false); // Adds a VARCHAR column named 'name' with a maximum length of 255 characters
            $table->string('description', 255)->nullable(); // Adds a VARCHAR column named 'description' with a maximum length of 255 characters
            $table->timestamps(); // Adds 'created_at' and 'updated_at' TIMESTAMP columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
