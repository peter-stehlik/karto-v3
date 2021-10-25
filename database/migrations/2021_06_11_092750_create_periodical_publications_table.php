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
            $table->date('label_date')->nullable();
            $table->date('accounting_date')->nullable()->comment("nema nic spolocne s uctovnym datumom pri uzivatelovi");
            $table->string('abbreviation', 20)->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->integer('current_number')->nullable();
            $table->integer('current_volume')->nullable();
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
        Schema::dropIfExists('periodical_publications');
    }
}
