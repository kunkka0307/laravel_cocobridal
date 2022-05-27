<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('タイトル');
            $table->decimal('lat', 10, 7)->nullable()->comment('緯度');
            $table->decimal('lang', 10, 7)->nullable()->comment('軽度');
            $table->text('comment')->nullable()->comment('コメント');
            $table->string('address')->nullable()->comment('住所');
            $table->string('access')->nullable()->comment('アクセス');
            $table->string('zipcode')->nullable()->comment('郵便番号');
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
        Schema::dropIfExists('rooms');
    }
}
