<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiereTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premiere_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chair_id')->unsigned();
            $table->integer('premiere_id')->unsigned();
            $table->date('date');
            $table->time('hour_initial');
            $table->time('hour_final');
            $table->double('ticket_price',10,2);
            $table->enum('active', [0,1])->default(1);
            $table->timestamps();

            $table->foreign('chair_id')->references('id')->on('chairs');
            $table->foreign('premiere_id')->references('id')->on('premieres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premiere_times');
    }
}
