<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorLinksTable extends Migration
{
    public function up()
    {
        Schema::create('autor_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor_id');
            $table->string('site_nome');
            $table->string('site_link');
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on('autores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('autor_links');
    }
}
