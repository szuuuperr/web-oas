<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories - add is_active if not exists
        if (! Schema::hasColumn('categories', 'is_active')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('description');
            });
        }

        // Purchase Orders - add is_active if not exists
        if (! Schema::hasColumn('purchase_orders', 'is_active')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('notes');
            });
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
