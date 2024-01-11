<?php
namespace src\Interfaces;
use \src\Article;

interface RepositoryArticleInterface
{
	function get(string $uuid): Article;
	function save(Article $article);
	public function delete(string $uuid);
}
