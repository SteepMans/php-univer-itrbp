<?php

namespace src\Http\Actions\Comments;

use Exception;
use src\Comment;
use src\Exceptions\HttpException;
use src\Http\Actions\ActionInterface;
use src\Interfaces\CommentsRepositoryInterface;
use src\Http\Request;
use src\Http\Response;
use src\Http\SuccessfulResponse;
use src\Http\ErrorResponse;

class CreateComment implements ActionInterface
{
    private CommentsRepositoryInterface $commentsRepository;

    public function __construct(CommentsRepositoryInterface $commentsRepositoryImplementation)
    {
        $this->commentsRepository = $commentsRepositoryImplementation;
    }

    public function handle(Request $request): Response
	{
        $newUuid = uniqid();

        try {
            $comment = new Comment(
                $newUuid,
                $request->jsonBodyField('author_uuid'),
                $request->jsonBodyField('post_uuid'),
                $request->jsonBodyField('text')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $this->commentsRepository->save($comment);
        } catch (Exception $exception){
            return new ErrorResponse('Cannot save article');
        }

        return new SuccessfulResponse([
            'uuid' => (string)$newUuid,
        ]);
    }
}