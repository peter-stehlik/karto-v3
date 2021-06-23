<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicalOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodical_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('periodical_publication_id');
            $table->integer('count');
            $table->decimal('credit', 14, 2);
            $table->date('valid_from');
            $table->date('valid_to');
            $table->string('note');
            $table->boolean('gratis');
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
        Schema::dropIfExists('periodical_orders');
    }
}
