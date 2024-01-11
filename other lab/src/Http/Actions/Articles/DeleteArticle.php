<?php

namespace src\Http\Actions\Articles;

use src\Http\SuccessfulResponse;
use src\Http\Actions\ActionInterface;
use src\Exceptions\HttpException;
use src\Http\ErrorResponse;
use src\Http\Request;
use src\Interfaces\RepositoryArticleInterface;
use src\Http\Response;

class DeleteArticle implements ActionInterface
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

        $this->articlesRepository->delete($articleId);

        return new SuccessfulResponse([]);
    }
}