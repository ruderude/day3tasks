<?php

use App\Support\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("messages", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("mid", 33)->index()->nullable(true)->comment("対象のLINEユーザー");
            $table->tinyInteger("dest")->nullable(false)->default(config("line.type.from"))->comment("宛先（from or to）");
            $table->tinyInteger("type")->nullable(false)->default(config("line.message.type.text"))->comment("LINEメッセージ種別");
            $table->string("text")->nullable(true)->comment("送信または受信の文字内容");
            $table->unsignedBigInteger("user_id")->index()->nullable(true)->comment("送信者ユーザーID");
            $table->tinyInteger("already")->nullable(false)->default(Flag::off)->comment("既読フラグ");
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
        Schema::dropIfExists('messages');
    }
}
