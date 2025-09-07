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
        Schema::create('customer_milk_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('milk_type_id')
                  ->constrained('milk_types')
                  ->onDelete('restrict');
            $table->decimal('default_qty', 8, 2)->default(0);
            $table->decimal('rate', 8, 2)->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'milk_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_milk_types');
    }
};
