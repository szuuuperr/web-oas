<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 50)->unique();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('batch_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
