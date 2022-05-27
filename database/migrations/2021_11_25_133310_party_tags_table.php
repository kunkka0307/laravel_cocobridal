<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartyTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('party_id')->nullable()->unsigned()->comment('パーティーID');
            $table->foreign('party_id')->references('id')->on('partys')->onDelete('cascade');
            $table->bigInteger('tag_id')->nullable()->unsigned()->comment('タグID');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('party_tags');
    }
}
