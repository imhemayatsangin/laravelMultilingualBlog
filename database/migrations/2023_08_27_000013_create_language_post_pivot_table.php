<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagePostPivotTable extends Migration
{
    public function up()
    {
        Schema::create('language_post', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id', 'post_id_fk_8925684')->references('id')->on('posts')->onDelete('cascade');
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id', 'language_id_fk_8925684')->references('id')->on('languages')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->boolean('status')->default(0)->nullable();
        });
    }
}
