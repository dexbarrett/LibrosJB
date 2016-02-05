<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(LibrosJB\User::class, function (Faker\Generator $faker) {
    return [
        'email' => 'admin@librosjb.com',
        'password' => 'topsecret',
        'admin' => 1
    ];
});

$factory->define(LibrosJB\Author::class, function(Faker\Generator $faker) {
    return [
        'name' => 'stephen king'
    ];
});

$factory->define(LibrosJB\Publisher::class, function(Faker\Generator $faker) {
    return [
        'name' => 'plaza janes'
    ];
});

$factory->define(LibrosJB\BookCondition::class, function(Faker\Generator $faker) {
    return [
        'name' => 'nuevo'
    ];
});

$factory->define(LibrosJB\BookLanguage::class, function(Faker\Generator $faker) {
    return [
        'name' => 'español'
    ];
});

$factory->define(LibrosJB\BookFormat::class, function(Faker\Generator $faker) {
    return [
        'name' => 'tapa blanda'
    ];
});