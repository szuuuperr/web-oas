<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->integer('period');
            $table->string('method', 50)->default('SMA');
            $table->decimal('predicted_value', 15, 2);
            $table->decimal('actual_value', 15, 2)->nullable();
            $table->decimal('accuracy', 5, 2)->nullable();
            $table->date('prediction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_predictions');
    }
};
