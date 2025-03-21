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
        Schema::table('commandes', function (Blueprint $table) {
            // Add missing columns from the controller but not in the table
            $table->string('reference')->nullable()->after('date');
            $table->decimal('subtotal', 10, 2)->default(0)->after('du');
            $table->decimal('tax_rate', 5, 2)->default(20)->after('subtotal');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate');
            $table->text('notes')->nullable()->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn([
                'reference',
                'subtotal',
                'tax_rate',
                'tax_amount',
                'notes'
            ]);
        });
    }
};