<?php
namespace src;

class Comment
{
	public string $id;
	public string $author_id;
	public string $article_id;
	public string $text;

	public function __construct(
		string $id = '',
		string $author_id = '',
		string $article_id = '',
		string $text = ''
	) {
		$this->id = $id;
		$this->author_id = $author_id;
		$this->article_id = $article_id;
		$this->text = $text;
	}

	public function __toString() {
        return "UUID: {$this->id}, Author ID: {$this->author_id}, Article ID: {$this->article_id}, Content: {$this->text}";
    }
}
