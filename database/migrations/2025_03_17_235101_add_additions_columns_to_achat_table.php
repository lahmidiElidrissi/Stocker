<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('achats', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('achats', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('contenir_id');
            }
            
            if (!Schema::hasColumn('achats', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(20)->after('subtotal');
            }
            
            if (!Schema::hasColumn('achats', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0)->after('tax_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achats', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('achats', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
            
            if (Schema::hasColumn('achats', 'tax_rate')) {
                $table->dropColumn('tax_rate');
            }
            
            if (Schema::hasColumn('achats', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }
        });
    }
};