<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->string('firstname', 100)->nullable()->comment('姓');
            $table->string('lastname', 100)->nullable()->comment('名');
            $table->string('furi_firstname', 100)->nullable()->comment('せい');
            $table->string('furi_lastname', 100)->nullable()->comment('めい');
            $table->enum('gender', \App\Enums\Gender::ALL_OPTIONS)->nullable()->comment('性別');
            $table->date('birthday')->nullable()->comment('生年月日');
            $table->string('phone', 20)->nullable()->comment('携帯電話番号');
            $table->string('pref')->nullable()->comment('都道府県');
            $table->text('comment')->nullable()->comment('自己紹介');
            $table->integer('job')->nullable()->comment('職業');
            $table->float('height')->nullable()->comment('身長');
            $table->integer('income')->nullable()->comment('年収');
            $table->integer('holiday')->nullable()->comment('休日');
            $table->json('hobby')->nullable()->comment('趣味');
            $table->integer('dwelling')->nullable()->comment('現在の住居');
            $table->integer('drink')->nullable()->comment('お酒');
            $table->integer('smoking')->nullable()->comment('喫煙');
            $table->integer('cooking')->nullable()->comment('料理');
            $table->string('best_cooking')->nullable()->comment('得意料理');
            $table->integer('birthplace')->nullable()->comment('出身地');
            $table->integer('bloodtype')->nullable()->comment('血液型');
            $table->integer('family')->nullable()->comment('続柄');
            $table->integer('marriage_history')->nullable()->comment('婚姻歴');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
