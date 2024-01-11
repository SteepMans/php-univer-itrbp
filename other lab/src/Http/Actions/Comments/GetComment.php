<?php

namespace src\Http\Actions\Comments;

use src\Exceptions\HttpException;
use src\Http\Actions\ActionInterface;
use src\Interfaces\CommentsRepositoryInterface;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;
use src\Http\ErrorResponse;


class GetComment implements ActionInterface
{
    private CommentsRepositoryInterface $commentsRepository;

    public function __construct(
        CommentsRepositoryInterface $commentsRepositoryImplementation
    )
    {
        $this->commentsRepository = $commentsRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        try {
            $commentId = $request->query('uuid');
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $comment = $this->commentsRepository->get($commentId);

        return new SuccessfulResponse(['comment' => $comment]);
    }
}