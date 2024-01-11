<?php
namespace src\Interfaces;
use src\Comment;

interface RepositoryCommentsInterface
{
	function get(string $uuid): Comment;
	function save(Comment $comment);
}
