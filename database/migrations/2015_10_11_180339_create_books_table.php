<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('author');
            $table->mediumInteger('pages');
            $table->mediumInteger('year');
            $table->string('publisher');
            $table->string('edition');
            $table->text('extract');
            $table->string('cover_picture');
            $table->boolean('for_sale')->default(false);
            $table->integer('sale_price');
            $table->string('condition');
            $table->text('comments')->nullable();
            $table->string('url_slug');
            $table->timestamps();

            $table->index('url_slug');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
