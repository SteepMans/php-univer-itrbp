<?php

require 'autoloader.php';
require 'vendor/autoload.php';

use src\Container\DIContainer;


$container = new DIContainer;

$db = new DataBase(__DIR__ . '/test.db');

$container->bind(SQLite3::class, $db);
$container->bind(RepositoryArticleInterface::class, ArticlesRepository::class);
$container->bind(RepositoryCommentsInterface::class, CommentsRepository::class);

return $container;