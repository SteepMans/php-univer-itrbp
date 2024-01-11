<?php

namespace src\Http\Actions\ArticleLikes;

use src\ArticleLike;
use src\Exceptions\HttpException;
use src\Http\ErrorResponse;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;
use src\Entities\Comment;
use src\Interfaces\CommentsRepositoryInterface;
use src\Http\Actions\ActionInterface;
use src\Interfaces\RepositoryArticleLikesInteface;

class LikeArticle implements ActionInterface
{
    private RepositoryArticleLikesInteface $articleLikesRepository;

    public function __construct(
        RepositoryArticleLikesInteface $articleLikesRepositoryImplementation,
    )
    {
        $this->articleLikesRepository = $articleLikesRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        $newUuid = uniqid();

        try {
            $like = new ArticleLike(
                $newUuid,
                $request->jsonBodyField('article_uuid'),
                $request->jsonBodyField('user_uuid')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->articleLikesRepository->save($like);

        return new SuccessfulResponse([
            'uuid' => (string)$newUuid,
        ]);
    }
}