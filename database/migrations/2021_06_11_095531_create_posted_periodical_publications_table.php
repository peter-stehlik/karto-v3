<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostedPeriodicalPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     * Zaúčtované periodiká.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posted_periodical_publications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('periodical_publication_id');
            $table->date('label_date')->nullable()->comment('štítky');
            $table->integer('posted_number')->nullable()->comment('Related to CURRENT NUMBER at periodical publications');
            $table->integer('posted_volume')->nullable()->comment('Related to CURRENT VOLUME at periodical publications');
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
        Schema::dropIfExists('posted_periodical_publications');
    }
}
