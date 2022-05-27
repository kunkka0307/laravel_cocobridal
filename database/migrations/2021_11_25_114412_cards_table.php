<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('card_number', 20)->nullable()->comment('カード番号');
            $table->integer('exp_year')->nullable()->comment('カード有効年');
            $table->integer('exp_month')->nullable()->comment('カード有効月');
            $table->string('name')->nullable()->comment('カード名義');
            $table->string('customer_id')->nullable()->comment('カスタマーID');
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
        Schema::dropIfExists('cards');
    }
}
