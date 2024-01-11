<?php

namespace src\Interfaces;

use src\ArticleLike;

interface RepositoryArticleLikesInteface 
{
    public function save(ArticleLike $article);
    public function getByPostUuid(string $uuid);
}

?>