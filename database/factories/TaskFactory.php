<?php
// app/database/factories/TaskFactory.php
use Faker\Generator as Faker;

$factory->define ( App\Task::class, function (Faker $faker) {
	$users = App\User::pluck ( 'id' )->toArray ();
	return [ 
			'name' => $faker->unique ()->name,
			'description' => $faker->text,
			'user_id' => $faker->randomElement ( $users ) 
	];
} );