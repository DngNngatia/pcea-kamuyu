<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLyricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lyrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('song_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('song_lyric');
            $table->integer('uploaded_by')->unsigned()->nullable();
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users');
            $table->foreign('song_id')
                ->references('id')
                ->on('songs');
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
        Schema::dropIfExists('lyrics');
    }
}
