<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('addresses', 'Zip_Code') && ! Schema::hasColumn('addresses', 'zip_code')) {
            // Works on MySQL 8+, but some MariaDB versions differ.
            try {
                DB::statement('ALTER TABLE `addresses` RENAME COLUMN `Zip_Code` TO `zip_code`');
            } catch (Throwable $e) {
                DB::statement('ALTER TABLE `addresses` CHANGE `Zip_Code` `zip_code` varchar(255) NULL');
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('addresses', 'zip_code') && ! Schema::hasColumn('addresses', 'Zip_Code')) {
            try {
                DB::statement('ALTER TABLE `addresses` RENAME COLUMN `zip_code` TO `Zip_Code`');
            } catch (Throwable $e) {
                DB::statement('ALTER TABLE `addresses` CHANGE `zip_code` `Zip_Code` varchar(255) NULL');
            }
        }
    }
};

