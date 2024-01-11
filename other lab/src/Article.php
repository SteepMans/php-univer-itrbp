<?php
namespace src;

class Article
{
	public string $id;
	public string $author_id;
	public string $title;
	public string $text;

	public function __construct(
		string $id = "",
		string $author_id = "",
		string $title = "",
		string $text = ""
	) {
		$this->id = $id;
		$this->author_id = $author_id;
		$this->title = $title;
		$this->text = $text;
	}

	public function __toString() {
        return "UUID: {$this->id}, Author ID: {$this->author_id}, Title: {$this->title}, Text: {$this->text}";
    }
}
