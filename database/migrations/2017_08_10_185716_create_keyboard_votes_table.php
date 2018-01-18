<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyboardVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyboard_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('keyboard_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->boolean('positive');
            $table->boolean('negative');
            $table->timestamps();

            ## Foreign keys
            $table->foreign('keyboard_id')->references('id')->on('keyboards')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyboard_votes');
    }
}
