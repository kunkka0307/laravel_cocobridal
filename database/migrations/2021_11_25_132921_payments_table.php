<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned()->comment('ユーザーID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('party_id')->nullable()->unsigned()->comment('パーティーID');
            $table->foreign('party_id')->references('id')->on('partys')->onDelete('cascade');
            $table->bigInteger('book_id')->nullable()->unsigned()->comment('Book ID');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->integer('amount')->nullable()->comment('決済金額');
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
        Schema::dropIfExists('payments');
    }
}
