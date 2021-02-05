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
            $table->string('title', 20);
            $table->string('name1', 50);
            $table->string('address1', 70);
            $table->string('address2', 70);
            $table->string('organization', 50);
            $table->string('zip_code', 20);
            $table->string('city', 70);
            $table->string('state', 20);
            $table->string('email', 50);
            $table->string('note');
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
