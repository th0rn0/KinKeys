<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyboard_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('keyboard_id')->unsigned()->index();
            $table->timestamps();

            ## Foreign keys
            $table->foreign('keyboard_id')->references('id')->on('keyboards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyboard_features');
    }
}
