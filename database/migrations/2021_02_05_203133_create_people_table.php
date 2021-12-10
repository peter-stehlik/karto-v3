<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('title', 20)->nullable();
            $table->string('name1', 70)->nullable();
            $table->string('name2', 70)->nullable();
            $table->string('address1', 70)->nullable();
            $table->string('address2', 70)->nullable();
            $table->string('organization', 50)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->string('city', 70)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
