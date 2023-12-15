<?php


interface RepositoryCommentsInterface
{
	function get(string $uuid): Comment;
	function save(Comment $comment);
}
