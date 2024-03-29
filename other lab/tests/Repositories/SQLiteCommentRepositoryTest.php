<?php

namespace Tests\Repositories;

use src\Core\DataBase;
use src\Comment;
use src\Repositories\CommentsRepository;
use PHPUnit\Framework\TestCase;
use src\Exceptions\NotFoundException;
use SQLite3Result;
use SQLite3Stmt;
use Tests\LoggerMock;

use function PHPUnit\Framework\assertEquals;

final class SQLiteCommentRepositoryTest extends TestCase
{
	public function testSave()
	{
		$connectionStub = $this->createStub(DataBase::class);
		$statementMock = $this->createMock(SQLite3Stmt::class);

		$statementMock->expects($this->once())->method('execute')->with();

		$connectionStub->method('prepare')->WillReturn($statementMock);

		$repository = new CommentsRepository($connectionStub, new LoggerMock);

		$comment = new Comment('111', '222', '333', 'text');
		$repository->save($comment);
	}

	public function testGetById()
	{
		$connectionStub = $this->createStub(DataBase::class);
		$statementMock = $this->createMock(SQLite3Stmt::class);


		$sqlResultMock = $this->createMock(SQLite3Result::class);
		$statementMock->expects($this->once())->method('execute')->WillReturn($sqlResultMock);

		$sqlResultMock->expects($this->once())
			->method('fetchArray')->with(SQLITE3_ASSOC)->WillReturn(
				[
					'uuid' => '111',
					'author_uuid' => '222',
					'article_uuid' => '333',
					'text' => 'text',
				]
			);

		$connectionStub->method('prepare')->WillReturn($statementMock);

		$repository = new CommentsRepository($connectionStub, new LoggerMock);

		$comment = new Comment('111', '222', '333', 'text');

		$result = $repository->get('111');

		assertEquals($comment, $result);
	}

	public function testGetByIdThrowsExceptionIfNotFound()
	{
		$connectionStub = $this->createStub(DataBase::class);
		$statementStub = $this->createStub(SQLite3Stmt::class);


		$statementStub->method('execute')->willReturn(false);

		$connectionStub->method('prepare')->willReturn($statementStub);

		$repository = new CommentsRepository($connectionStub, new LoggerMock);

		$this->expectException(NotFoundException::class);

		$uuid = "111";
		$repository->get($uuid);
	}
}