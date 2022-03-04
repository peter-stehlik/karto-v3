<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrections', function (Blueprint $table) {
            $table->id();
            $table->integer('from_person_id');
            $table->integer('for_person_id');
            $table->decimal('sum', 14, 2);
            $table->integer('from_periodical_id')->nullable();
            $table->integer('from_nonperiodical_id')->nullable();
            $table->integer('for_periodical_id')->nullable();
            $table->integer('for_nonperiodical_id')->nullable();
            $table->integer('user_id');
            $table->boolean('confirmed');
            $table->string('note')->nullable();
            $table->timestamp('correction_date')->nullable();
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
        Schema::dropIfExists('corrections');
    }
}
