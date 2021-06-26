<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("followers", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("mid", 33)->index()->unique()->comment("LINEユーザーID");
            $table->string("name", 20)->nullable(false)->default("")->comment("LINE名");
            $table->string("icon_url")->nullable(true)->comment("LINEアイコン画像");
            $table->dateTime("blocked_at")->nullable(true)->comment("ブロック日時");
            $table->dateTime("freeze_at")->nullable(true)->comment("凍結日時");
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
        Schema::dropIfExists('followers');
    }
}
