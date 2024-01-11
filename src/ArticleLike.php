<?php

namespace src;

class ArticleLike {
    public string $uuid;
    public string $article_uuid;
    public string $user_uuid;

    public function __construct($uuid, $article_uuid, $user_uuid) {
        $this->uuid = $uuid;
        $this->article_uuid = $article_uuid;
        $this->user_uuid = $user_uuid;
    }

    public function __toString() {
        return "UUID: {$this->uuid}, Article UUID: {$this->article_uuid}, User UUID: {$this->user_uuid}";
    }
}