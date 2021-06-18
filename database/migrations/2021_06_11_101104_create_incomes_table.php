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
            $table->decimal('sum', 14, 2)->nullable();
            $table->integer('bank_account_id');
            $table->integer('number')->nullable();
            $table->integer('package_number')->nullable()->comment("pomocna charakteristika");
            $table->integer('invoice')->nullable()->comment("pomocna charakteristika");
            $table->timestamp('accounting_date')->nullable();
            $table->boolean('confirmed')->comment("potvrdeny (zauctovany) prijem");
            $table->string('note')->nullable();
            $table->timestamp('income_date')->nullable()->comment("spravca moze nastavit");
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
