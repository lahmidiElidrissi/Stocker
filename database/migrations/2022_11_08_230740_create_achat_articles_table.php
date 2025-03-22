<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchatArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achat_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achat_id')->nullable();
            $table->foreign("achat_id")->references('id')->on('Achats')->onDelete('cascade');
            $table->unsignedBigInteger('article_id');
            $table->foreign("article_id")->references('id')->on('Articles')->onDelete('cascade');
            $table->integer('Quantite');
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
        Schema::dropIfExists('achat_articles');
    }
}
