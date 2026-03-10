<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // products.brands_id -> products.brand_id
        if (Schema::hasColumn('products', 'brands_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['brands_id']);
                $table->renameColumn('brands_id', 'brand_id');
            });
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            });
        }

        // addresses.orders_id -> addresses.order_id
        if (Schema::hasColumn('addresses', 'orders_id')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropForeign(['orders_id']);
                $table->renameColumn('orders_id', 'order_id');
            });
            Schema::table('addresses', function (Blueprint $table) {
                $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            });
        }

        // addresses.Zip_Code -> addresses.zip_code
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'Zip_Code') && ! Schema::hasColumn('addresses', 'zip_code')) {
                $table->renameColumn('Zip_Code', 'zip_code');
            }
        });
    }

    public function down(): void
    {
        // addresses.zip_code -> addresses.Zip_Code
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'zip_code') && ! Schema::hasColumn('addresses', 'Zip_Code')) {
                $table->renameColumn('zip_code', 'Zip_Code');
            }
        });

        // addresses.order_id -> addresses.orders_id
        if (Schema::hasColumn('addresses', 'order_id')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
                $table->renameColumn('order_id', 'orders_id');
            });
            Schema::table('addresses', function (Blueprint $table) {
                $table->foreign('orders_id')->references('id')->on('orders')->cascadeOnDelete();
            });
        }

        // products.brand_id -> products.brands_id
        if (Schema::hasColumn('products', 'brand_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['brand_id']);
                $table->renameColumn('brand_id', 'brands_id');
            });
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('brands_id')->references('id')->on('brands')->cascadeOnDelete();
            });
        }
    }
};

