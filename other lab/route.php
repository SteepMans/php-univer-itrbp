<?php

use src\Http\Actions\Comments\CreateComment;
use src\Http\Actions\Comments\GetComment;
use src\Http\Actions\Articles\CreateArticle;
use src\Http\Actions\Articles\DeleteArticle;
use src\Http\Actions\Articles\GetArticle;
use src\Http\Actions\Articles\GetArticleLikes;
use src\Http\Actions\ArticleLikes\LikeArticle;
use src\Http\ErrorResponse;
use src\Http\Request;

$di_container = require __DIR__ . '/bootstrap.php';

$routes = [
	'GET' => 
	[
		'/posts' => GetArticle::class,
		'/comment' => GetComment::class,
		'/likes' => GetArticleLikes::class
	],
	'POST' => 
	[
		'/posts/comment' => CreateComment::class,
		'/posts' => CreateArticle::class,
		'/posts/like' => LikeArticle::class
	],
	'DELETE' => 
	[
		'/posts' => DeleteArticle::class
	]
];

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));
$path = $request->path();
$method = $request->method();

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
	$message = "Undefined route: $method $path";
	(new ErrorResponse($message))->send();
	return;
}

$actionClassName = $routes[$method][$path];
$action = $di_container->get($actionClassName);

try {
	$response = $action->handle($request);
	$response->send();
} catch (Exception $error) {
	(new ErrorResponse($error->errorMessage()))->send();
}