<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partys', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('タイトル');
            $table->string('eyecatch', 1000)->nullable()->comment('アイキャッチ画像');
            $table->integer('male_limit')->nullable()->comment('男性座席数');
            $table->integer('female_limit')->nullable()->comment('女性座席数');
            $table->integer('male_price')->nullable()->comment('男性料金');
            $table->integer('female_price')->nullable()->comment('女性料金');
            $table->bigInteger('room_id')->nullable()->unsigned()->comment('会場ID');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->text('content')->nullable()->comment('詳細');
            $table->date('open_date')->nullable()->comment('開始日');
            $table->time('open_time')->nullable()->comment('開始時間');
            $table->time('close_time')->nullable()->comment('終了時間');
            $table->integer('male_high_age')->nullable()->comment('男性年齢上限');
            $table->integer('male_low_age')->nullable()->comment('男性年齢下限');
            $table->integer('female_high_age')->nullable()->comment('女性年齢上限');
            $table->integer('female_low_age')->nullable()->comment('女性年齢下限');
            $table->integer('value_sense')->nullable()->comment('価値観');
            $table->json('flows')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partys');
    }
}
