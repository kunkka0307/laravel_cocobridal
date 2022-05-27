<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('party_id')->nullable()->unsigned()->comment('パーティーID');
            $table->foreign('party_id')->references('id')->on('partys')->onDelete('cascade');
            $table->integer('status')->nullable()->comment('予約状態');
            $table->integer('amount')->nullable()->comment('決済金額');
            $table->integer('friend')->default(0);
            $table->json('friend_info')->nullable();
            // $table->integer('refund')->nullable();
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
        Schema::dropIfExists('books');
    }
}
