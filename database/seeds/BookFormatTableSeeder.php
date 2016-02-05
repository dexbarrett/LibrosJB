<?php

use Illuminate\Database\Seeder;

class BookFormatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_format')->truncate();

        factory(LibrosJB\BookFormat::class)->create();
    }
}
