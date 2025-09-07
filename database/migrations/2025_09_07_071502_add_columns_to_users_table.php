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
            $table->text('flat_no')->nullable()->after('password');
            $table->string('phone')->nullable()->after('flat_no');
            $table->foreignId('milk_type_id')->nullable()->constrained('milk_types')->after('phone');
            $table->decimal('default_qty')->nullable()->after('milk_type_id');
            $table->decimal('rate')->default('0')->after('default_qty');
            $table->tinyInteger('status')->default(1)->after('rate');
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
