<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // products.brand_id (missing in current DB)
        if (! Schema::hasColumn('products', 'brand_id') && ! Schema::hasColumn('products', 'brands_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('brand_id')
                    ->nullable()
                    ->constrained('brands')
                    ->nullOnDelete()
                    ->after('category_id');
            });
        }

        // addresses.order_id (missing in current DB)
        if (! Schema::hasColumn('addresses', 'order_id') && ! Schema::hasColumn('addresses', 'orders_id')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->foreignId('order_id')
                    ->nullable()
                    ->constrained('orders')
                    ->cascadeOnDelete()
                    ->after('id');
            });
        }

        // addresses.Zip_Code -> addresses.zip_code (current DB has Zip_Code)
        if (Schema::hasColumn('addresses', 'Zip_Code') && ! Schema::hasColumn('addresses', 'zip_code')) {
            DB::statement('ALTER TABLE `addresses` RENAME COLUMN `Zip_Code` TO `zip_code`');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('addresses', 'zip_code') && ! Schema::hasColumn('addresses', 'Zip_Code')) {
            DB::statement('ALTER TABLE `addresses` RENAME COLUMN `zip_code` TO `Zip_Code`');
        }

        if (Schema::hasColumn('addresses', 'order_id')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            });
        }

        if (Schema::hasColumn('products', 'brand_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['brand_id']);
                $table->dropColumn('brand_id');
            });
        }
    }
};

