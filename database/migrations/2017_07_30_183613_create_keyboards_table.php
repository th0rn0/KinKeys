<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyboards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image_feature');
            $table->string('image_thumbnail');
            $table->string('images', 5000);
            $table->string('desc_short');
            $table->string('desc_long', 1000);
            $table->timestamps();

            ## Foreign keys
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
        $table->dropForeign('keyboards_user_id_foreign');

        Schema::dropIfExists('keyboards');
    }
}
