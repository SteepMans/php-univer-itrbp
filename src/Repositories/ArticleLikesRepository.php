<?php 

namespace lab3\Blog\Repositories;

use Psr\Log\LoggerInterface;
use src\Interfaces\RepositoryArticleLikesInteface;
use src\ArticleLike;
use src\Exceptions\EntityNotFoundException;
use src\Exceptions\OperationNotAllowedException;
use SQLite3;

class SQLiteArticleLikesRepository implements RepositoryArticleLikesInteface
{
    public SQLite3 $database;
	private LoggerInterface $logger;

	public function __construct(SQLite3 $database = null, LoggerInterface $logger)
	{
		$this->database = $database;
		$this->logger = $logger;
	}

    public function save(ArticleLike $like) 
    {
		$this->logger->info("Article like save ".$like->uuid);

		$result = $this->isLikeExists($like->article_uuid, $like->user_uuid);

		if ($result){
			throw new OperationNotAllowedException("no likes found");
		}

        $query = $this->database->prepare(
			'INSERT INTO `likes` (uuid, article_uuid, user_uuid) VALUES (:uuid, :article_uuid, :user_uuid)'
		);

		$query->bindValue(':uuid', $like->uuid);
		$query->bindValue(':article_uuid',$like->article_uuid);
		$query->bindValue(':user_uuid', $like->user_uuid);

		$query->execute();
    }

	public function isLikeExists(string $article_uuid, string $user_uuid)
    {
		$query = $this->database->prepare('SELECT * FROM `likes` WHERE `article_id` =:article_uuid AND `user_id` = :user_id');

		$query->bindValue(':article_uuid', $article_uuid);
		$query->bindValue(':user_uuid', $user_uuid);

		$result = $query->execute();
		
		if ($result === false) {
			throw new EntityNotFoundException();
		}

		$likesList = [];

		while ($row = $result->fetchArray(SQLITE3_ASSOC)){


			$like = new ArticleLike(
				$row["uuid"],
				$row["article_uuid"],
				$row["user_uuid"],
			);

			array_push($likesList, $like);

		}

        $isResultValue = false;

		if (count($likesList) > 0) 
            $isResultValue = true;

		return $isResultValue;
        
    }
    
    public function getByPostUuid(string $uuid) 
    {
		$query = $this->database->prepare('SELECT * FROM `likes` WHERE `article_id` = :uuid');
		$query->bindValue(':uuid', $uuid);
		$result = $query->execute();

		if ($result === false) {
			$this->logger->warning("Likes for object not found " . $uuid);
			throw new EntityNotFoundException();
		}
		
        $likes = [];

		while ($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			$like = new ArticleLike(
				$row["uuid"],
				$row["article_uuid"],
				$row["user_uuid"]
			);
			array_push($likes, $like);
		}

		return $likes;
    }
}

?>