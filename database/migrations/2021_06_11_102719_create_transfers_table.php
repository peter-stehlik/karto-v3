<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id');
            $table->decimal('sum', 14, 2);
            $table->integer('periodical_publication_id');
            $table->integer('nonperiodical_publication_id');
            $table->string('note');
            $table->timestamp('transfer_date')->nullable()->comment("spravca moze nastavit");
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
        Schema::dropIfExists('transfers');
    }
}
