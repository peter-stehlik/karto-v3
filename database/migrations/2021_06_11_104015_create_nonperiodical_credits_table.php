<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonperiodicalCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonperiodical_credits', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('nonperiodical_publication_id');
            $table->decimal('credit', 14, 2);
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
        Schema::dropIfExists('nonperiodical_credits');
    }
}
