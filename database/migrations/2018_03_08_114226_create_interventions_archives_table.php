<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterventionsArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions_archives', function (Blueprint $table) {
            $table->increments('id_intervention');

            $table->integer('id_type_intervention');
            $table->integer('id_user');
            $table->integer('id_equipement');

            $table->string('description',255);

            $table->dateTime('date');
            $table->time('duree');

            $table->dateTime('date_delete');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interventions_archives');
    }
}
