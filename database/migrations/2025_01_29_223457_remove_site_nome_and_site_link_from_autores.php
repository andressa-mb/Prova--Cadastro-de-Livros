<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveSiteNomeAndSiteLinkFromAutores extends Migration
{
    public function up()
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->dropColumn(['site-nome', 'site-link']);
            DB::table('autores')->truncate();
        });
    }

    public function down()
    {
        Schema::table('autores', function (Blueprint $table) {
            $table->string('site_nome')->nullable();
            $table->string('site_link')->nullable();
        });
    }
}
