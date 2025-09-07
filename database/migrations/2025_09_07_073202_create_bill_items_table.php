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
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')
                ->constrained('bills')
                ->onDelete('cascade');            
            $table->foreignId('milk_type_id')
                ->constrained('milk_types')
                ->onDelete('restrict');
            $table->decimal('total_liters', 8, 2)->default(0);
            $table->decimal('rate', 8, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_items');
    }
};
