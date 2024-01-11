<?php

namespace src\Http\Actions\Articles;

use Exception;
use src\Article;
use src\Http\ErrorResponse;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;
use src\Interfaces\RepositoryArticleInterface;
use src\Exceptions\HttpException;
use src\Http\Actions\ActionInterface;

class CreateArticle implements ActionInterface
{
    private RepositoryArticleInterface $articlesRepository;

    public function __construct(RepositoryArticleInterface $articlesRepositoryImplementation = null)
    {
        $this->articlesRepository = $articlesRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        $newUuid = uniqid();

        try {
            $article = new Article(
                $newUuid,
                $request->jsonBodyField('author_uuid'),
                $request->jsonBodyField('header'),
                $request->jsonBodyField('content')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        if (strlen($article->author_id) != 13 or !preg_match("/^[a-zA-Z0-9]+$/",$article->author_id)){
            return new ErrorResponse('Author id is invalid');
        }

        try {
            $this->articlesRepository->save($article);
        } catch (Exception $exception){
            return new ErrorResponse('Cannot save article');
        }

        return new SuccessfulResponse([
            'uuid' => (string)$newUuid,
        ]);
    }
}