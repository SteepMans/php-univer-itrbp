<?php
interface RepositoryArticleInterface
{
	function get(string $uuid): Article;
	function save(Article $article);
}
