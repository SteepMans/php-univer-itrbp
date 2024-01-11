<?php

namespace src\Http\Actions\Articles;

use src\Exceptions\HttpException;
use src\Http\ErrorResponse;
use src\Http\Actions\ActionInterface;
use src\Interfaces\RepositoryArticleInterface;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;

class GetArticle implements ActionInterface
{
    private RepositoryArticleInterface $articlesRepository;

    public function __construct(
        RepositoryArticleInterface $articlesRepositoryImplementation
    )
    {
        $this->articlesRepository = $articlesRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        try {
            $articleId = $request->query('uuid');
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $article = $this->articlesRepository->get($articleId);

        return new SuccessfulResponse(['article' => $article]);
    }
}