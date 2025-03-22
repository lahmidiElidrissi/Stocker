<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->unsignedBigInteger('contenir_id')->nullable();
            $table->foreign("contenir_id")->references('id')->on('contenirs')->onDelete('set null');
            $table->unsignedBigInteger('fournisseur_id')->nullable();
            $table->foreign("fournisseur_id")->references('id')->on('fournisseurs')->onDelete('set null');
            $table->integer('total');
            $table->integer('paye')->nullable();
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
        Schema::dropIfExists('achats');
    }
}
