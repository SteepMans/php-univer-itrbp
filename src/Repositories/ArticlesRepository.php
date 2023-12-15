<?php
include_once "../Core/DataBase.php";
use Article;
use RepositoryArticleInterface;

class ArticlesRepository implements RepositoryArticleInterface
{
	public DataBase $db;

	public function __construct(DataBase $db = null)
	{
		$this->db = $db;
	}
	public function get(string $uuid): Article
	{
		$result = $this->db->query("SELECT * FROM user WHERE `uuid` = $uuid");

		$result->fetchArray();

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
		return $article;
	}
}