<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('user_id');
            $table->decimal('sum', 14, 2);
            $table->integer('bank_account_id');
            $table->integer('number');
            $table->integer('package_number')->comment("pomocna charakteristika");
            $table->integer('invoice')->comment("pomocna charakteristika");
            $table->date('accounting_date');
            $table->boolean('posted');
            $table->string('note');
            $table->date('income_date')->comment("spravca moze nastavit");
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
        Schema::dropIfExists('incomes');
    }
}
