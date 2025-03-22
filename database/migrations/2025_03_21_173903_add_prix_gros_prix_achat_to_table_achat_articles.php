<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achat_articles', function (Blueprint $table) {
            $table->float('prix_gros')->nullable();
            $table->float('prix_achat')->nullable();
            $table->float('prix_importation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achat_articles', function (Blueprint $table) {
            $table->dropColumn('prix_gros');
            $table->dropColumn('prix_achat');
            $table->dropColumn('prix_importation');
        });
    }
};
