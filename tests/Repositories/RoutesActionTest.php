<?php

namespace Tests;

use Exception;
use \src\Article;
use \src\User;
use \src\Exceptions\EntityNotFoundException;
use \src\Http\Actions\Articles\CreateArticle;
use \src\Http\ErrorResponse;
use \src\Http\Request;
use \src\Http\SuccessfulResponse;
use \src\Interfaces\RepositoryArticleInterface;
use PHPUnit\Framework\TestCase;

include "autoloader.php";

final class RoutesActionTest extends TestCase
{
	private function getArticlesRepository(array $articles, array $users): RepositoryArticleInterface
    {
        return new class($articles, $users) implements RepositoryArticleInterface
        {
            public function __construct(
                private array $articles,
                private array $users
            ) {
            }

            public function save(Article $article): void
            {
                $user_exists = false;
                foreach ($this->users as $user) {
                    if ($user->uuid == $article->author_id) {
                        $user_exists = true;
                        break;
                    }
                }

                if (!$user_exists) {
                    throw new Exception();
                }

                array_push($this->articles, $article);
            }

            public function get(string $uuid): Article
            {
                throw new EntityNotFoundException();
            }

            public function delete(string $uuid)
            {
                throw new Exception();
            }
        };
    }
	
	function testUuid() 
	{
		$request = new Request([], [], '{
            "author_uuid": "1111",
            "header": "header",
            "content": "content"
        }');
        $repository = $this->getArticlesRepository([], [new User('1111', 'name', 'surname', 'nick')]);
        $action = new CreateArticle($repository);
        $response = $action->handle($request);

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Author id is invalid"}');

        $response->send();
	}

	function testNotFoundUserUuid() 
	{
		$request = new Request([], [], '{
            "author_uuid": "xxxxxxxxxxxxy",
            "header": "header",
            "content": "content"
        }');
        $repository = $this->getArticlesRepository([], [new User('1111', 'name', 'surname', 'nick')]);
        $action = new CreateArticle($repository);
        $response = $action->handle($request);
        
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Cannot save article"}');

        $response->send();
	}

	function testNotEnoughData() 
	{
		$request = new Request([], [], '{
            "author_uuid": "1111",
            "header": "header",
        }');
        $repository = $this->getArticlesRepository([], [new User('1111', 'name', 'surname', 'nick')]);
        $action = new CreateArticle($repository);
        $response = $action->handle($request);

        $this->assertInstanceOf(ErrorResponse::class, $response);

        $response->send();
	}

    function testSuccess() 
	{
		$request = new Request([], [], '{
            "author_uuid": "1111",
            "header": "header",
            "content": "content"
        }');
        $repository = $this->getArticlesRepository([], [new User('1111', 'name', 'surname', 'nick')]);
        $action = new CreateArticle($repository);
        $response = $action->handle($request);

        $this->assertInstanceOf(SuccessfulResponse::class, $response);
        $response->send();
	}
}