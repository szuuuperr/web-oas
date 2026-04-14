<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // purchase_orders - add approved_at, rejected_at if not exist
        if (! Schema::hasColumn('purchase_orders', 'approved_at')) {
            Schema::table('purchase_orders', function (Blueprint $table) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
                $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            });
        }

        // stock_alerts - add resolved_at if not exist
        if (! Schema::hasColumn('stock_alerts', 'resolved_at')) {
            Schema::table('stock_alerts', function (Blueprint $table) {
                $table->timestamp('resolved_at')->nullable()->after('is_resolved');
            });
        }
    }

    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['approved_at', 'rejected_at']);
        });
        Schema::table('stock_alerts', function (Blueprint $table) {
            $table->dropColumn('resolved_at');
        });
    }
};
