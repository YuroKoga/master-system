<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            DB::statement('ALTER TABLE `plans` MODIFY COLUMN `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;');
            DB::statement('ALTER TABLE `plans` MODIFY COLUMN `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            DB::statement('ALTER TABLE `plans` MODIFY COLUMN `updated_at` TIMESTAMP NOT NULL;');
            DB::statement('ALTER TABLE `plans` MODIFY COLUMN `created_at` TIMESTAMP NOT NULL;');
        });
    }
};
