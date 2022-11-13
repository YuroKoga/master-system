<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->string('address')->nullable()->default(null);  //カラム追加
            $table->integer('reviews')->unsigned()->default(0);  //カラム追加
            $table->string('url')->nullable()->default(null);  //カラム追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn('address');  //カラムの削除
            $table->dropColumn('reviews');
            $table->dropColumn('url');
        });
    }
};
