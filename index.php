<?php

namespace src;
require 'autoloader.php';

use src\Article;
use src\Comment;
use src\User;
use Faker\Factory;

$faker = Factory::create();

$article = new Article($faker->randomNumber(), $faker->randomNumber(), $faker->text, $faker->text);
$comment = new Comment($faker->randomNumber(), $faker->randomNumber(),$faker->randomNumber(), $faker->text);
$user = new User($faker->randomNumber(), $faker->text, $faker->text, $faker->text);

echo $article . '</br>';
echo $comment . '</br>';
echo $user . '</br>';
?>