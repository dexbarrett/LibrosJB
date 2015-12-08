<?php

use Illuminate\Database\Seeder;

class BookConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_conditions')->truncate();

        factory(LibrosJB\BookCondition::class)->create();
    }
}
