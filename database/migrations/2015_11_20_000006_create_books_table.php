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
            $table->integer('author_id')->unsigned();
            $table->mediumInteger('pages');
            $table->mediumInteger('edition_year');
            $table->integer('publisher_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->text('extract');
            $table->string('cover_picture');
            $table->boolean('for_sale')->default(false);
            $table->integer('sale_price');
            $table->integer('book_condition_id')->unsigned();
            $table->text('comments')->nullable();
            $table->string('url_slug');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->foreign('book_condition_id')->references('id')->on('book_conditions');
            $table->foreign('language_id')->references('id')->on('languages');

            $table->index('url_slug');

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
