<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("mid")->comment("LINEのmid");
            $table->foreign("mid")->references("mid")->on("followers")->OnDelete("cascade");
            $table->string("title")->comment("タスクタイトル");
            $table->text("detail")->nullable(true)->comment("タスク詳細");
            $table->boolean("done")->nullable(false)->default(false)->comment("完了フラグ");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
