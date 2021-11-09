<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public function selectByGenre(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT *
            FROM genre
            JOIN game_genre
            ON id=genre_id
            WHERE id=:id"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllGamesFromCategoryId(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT `name`, picture, game_id, genre_id
            FROM game
            RIGHT JOIN game_genre
            ON id=game_id
            WHERE :id=genre_id;"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllCategoryFromGameId(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT genre_id
            FROM game_genre
            WHERE :id=game_id"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectNameByTagId($id)
    {
        $statement = $this->pdo->prepare(
            "SELECT `name`
            FROM genre
            WHERE :id=id"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
