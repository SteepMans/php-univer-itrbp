<?php

namespace Tests\Repositories;

use src\Core\DataBase;
use src\Article;
use src\Repositories\ArticlesRepository;
use PHPUnit\Framework\TestCase;
use src\Exceptions\NotFoundException;
use SQLite3Result;
use SQLite3Stmt;
use Tests\LoggerMock;

use function PHPUnit\Framework\assertEquals;

include "autoloader.php";

final class SQLiteArticleRepositoryTest extends TestCase
{
	public function testSave()
	{
		$connectionStub = $this->createStub(DataBase::class);
		$statementMock = $this->createMock(SQLite3Stmt::class);

		var_dump($statementMock->expects($this->once())->method('execute'));
		return;

		$statementMock->expects($this->once())->method('execute')->with();

		$connectionStub->method('prepare')->WillReturn($statementMock);

		$repository = new ArticlesRepository($connectionStub, new LoggerMock);
		$article = new Article('111', '111', '111', '111');
		$repository->save($article);
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
					'text' => '111',
					'title' => '111',
					'author_uuid' => '111'
				]
			);

		$connectionStub->method('prepare')->WillReturn($statementMock);

		$repository = new ArticlesRepository($connectionStub, new LoggerMock);
		$article = new Article('111', '111', '111', '111');

		$result = $repository->get('111');

		assertEquals($article, $result);
	}

	public function testGetByIdThrowsExceptionIfNotFound()
	{
		$connectionStub = $this->createStub(DataBase::class);
		$statementStub = $this->createStub(SQLite3Stmt::class);

		$statementStub->method('execute')->willReturn(false);
		$connectionStub->method('prepare')->willReturn($statementStub);

		$repository = new ArticlesRepository($connectionStub, new LoggerMock);

		$this->expectException(NotFoundException::class);

		$uuid = "111";
		$repository->get($uuid);
	}
}