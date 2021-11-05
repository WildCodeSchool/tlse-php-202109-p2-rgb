<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public function selectByGenre(int $id)
    {
        $statement = $this->pdo->query("SELECT DISTINCT name FROM genre JOIN game_genre ON id=genre_id WHERE id=$id");
        $genre = $statement->fetch(PDO::FETCH_ASSOC);
        return $genre;
    }

    public function selectAllGamesFromCategoryId(int $id)
    {
        $query = "SELECT name, picture, game_id, genre_id 
        FROM game 
        RIGHT JOIN game_genre 
        ON id=game_id 
        WHERE $id=genre_id";
        $statement = $this->pdo->query($query);
        $gameInfos = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $gameInfos;
    }
}
