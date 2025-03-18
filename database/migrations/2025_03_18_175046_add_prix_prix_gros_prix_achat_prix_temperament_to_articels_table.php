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
        Schema::table('articles', function (Blueprint $table) {
            // Add new price columns if they don't exist
            if (!Schema::hasColumn('articles', 'prix_gros')) {
                $table->decimal('prix_gros', 10, 2)->nullable()->after('Prix')->comment('Prix de gros');
            }
            
            if (!Schema::hasColumn('articles', 'prix_achat')) {
                $table->decimal('prix_achat', 10, 2)->nullable()->after('prix_gros')->comment('Prix d\'achat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop new columns if they exist
            if (Schema::hasColumn('articles', 'prix_gros')) {
                $table->dropColumn('prix_gros');
            }
            
            if (Schema::hasColumn('articles', 'prix_achat')) {
                $table->dropColumn('prix_achat');
            }
        });
    }
};