<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartyFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_flows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('party_id')->nullable()->unsigned()->comment('パーティーID');
            $table->foreign('party_id')->references('id')->on('partys')->onDelete('cascade');
            $table->string('title')->nullable()->comment('タイトル');
            $table->time('start_time')->nullable()->comment('開始時間');
            $table->integer('sort')->nullable()->comment('順番');
            $table->text('comment')->nullable()->comment('コメント');
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
        Schema::dropIfExists('party_flows');
    }
}
