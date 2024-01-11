<?php

namespace src\Http\Actions\Articles;

use src\Exceptions\HttpException;
use src\Http\ErrorResponse;
use src\Http\Actions\ActionInterface;
use src\Interfaces\RepositoryArticleLikesInteface;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;

class GetArticleLikes implements ActionInterface
{
    private RepositoryArticleLikesInteface $articleLikesRepository;

    public function __construct(
        RepositoryArticleLikesInteface $articleLikesRepositoryImplementation
    )
    {
        $this->articleLikesRepository = $articleLikesRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        try {
            $articleId = $request->query('uuid');
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $likes = $this->articleLikesRepository->getByPostUuid($articleId);

        return new SuccessfulResponse(['likes' => $likes]);
    }
}