<?php

namespace App\Model;

use PDO;

class SearchManager extends AbstractManager
{
    public function selectByTitleGame(string $id): ?array
    {
        $statement = $this->pdo->prepare("SELECT * 
        FROM game 
        JOIN list_user 
        ON user_id = :userId
        WHERE game.id=game_id
        AND game.name LIKE :search ");
        $statement->bindValue(':search', "%$id%", \PDO::PARAM_STR);
        $statement->bindValue(':userId', $_SESSION['userId'], \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getTagId(string $tag)
    {
        $query = "SELECT id FROM genre WHERE name= :tag;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":tag", $tag, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function searchByTag(string $tag)
    {
        $idTag = intval($this->getTagId($tag)['id'], 10);

        $query = "SELECT * 
        FROM game
        JOIN list_user
        ON list_user.user_id = :userId
        AND list_user.game_id = game.id
        JOIN game_genre
        ON game_genre.genre_id = :idTag
        AND game_genre.game_id = list_user.game_id;";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":userId", intval($_SESSION['userId'], 10), PDO::PARAM_INT);
        $statement->bindValue(":idTag", intVal($idTag), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
