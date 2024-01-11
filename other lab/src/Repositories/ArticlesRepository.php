<?php
namespace src\Repositories;

include_once "../Core/DataBase.php";

use Psr\Log\LoggerInterface;
use \src\Article;
use \src\Interfaces\RepositoryArticleInterface;
use \src\Core\DataBase;
use \src\Exceptions\EntityNotFoundException;

class ArticlesRepository implements RepositoryArticleInterface
{
	public DataBase $db;
	private LoggerInterface $logger;

	public function __construct(DataBase $db = null, LoggerInterface $logger)
	{
		$this->db = $db;
		$this->logger = $logger;
	}
	public function get(string $uuid): Article
	{
		$result = $this->db->query("SELECT * FROM user WHERE `uuid` = $uuid");

		$result->fetchArray();

		if ($result == false) {
			$this->logger->warning("Article not found from user " . $uuid);
		}

		$article = new Article(
			text: $result["text"],
			id: $result["id"],
			title: $result["title"],
			author_id: $result["author_id"],
		);

		return $article;
	}

	public function save(Article $article)
	{
		$query = "INSERT INTO articles (uuid, title, text, author_uuid)
					VALUES(\"$article->id\", \"$article->title\", \"$article->text\", \"$article->author_id\") 
					ON CONFLICT(uuid) DO UPDATE SET `title` = excluded.title, `text` = excluded.text, `author_uuid` = excluded.author_uuid;";

		$this->db->exec($query);

		$this->logger->info("Articles save " . $article->id);
		return $article;
	}

	public function delete(string $uuid)
	{
		$query = $this->db->prepare('DELETE FROM articles WHERE uuid=:uuid');
		$query->bindValue(':uuid', $uuid);
		$result = $query->execute();

		if ($result === false) {
			$this->logger->info("Articles delete not found " . $uuid);
			throw new EntityNotFoundException();
		}

		$this->logger->info("Articles delete " . $uuid);
	}
}