<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicalPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodical_publications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->date('label_date');
            $table->string('abbrevation', 20);
            $table->decimal('price', 14, 2);
            $table->integer('current_number');
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
        Schema::dropIfExists('periodical_publications');
    }
}
