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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'milk_type_id')) {
                $table->dropForeign(['milk_type_id']);
                $table->dropColumn('milk_type_id');
            }

            if (Schema::hasColumn('users', 'default_qty')) {
                $table->dropColumn('default_qty');
            }

            if (Schema::hasColumn('users', 'rate')) {
                $table->dropColumn('rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
