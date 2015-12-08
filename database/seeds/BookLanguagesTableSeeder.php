<?php

use Illuminate\Database\Seeder;

class BookLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();

        factory(LibrosJB\BookLanguage::class)->create();
    }
}
