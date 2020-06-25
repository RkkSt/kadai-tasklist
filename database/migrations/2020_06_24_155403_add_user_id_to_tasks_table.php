<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // unsigned→マイナスにならないようにする設定
            $table->bigInteger('user_id')->unsigned()->index();

            // 外部キー制約 userテーブルのidとuser_idを紐づけする。
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 外部キーの削除
            $table->dropForeign('tasks_user_id_foreign');
        });
    }
}