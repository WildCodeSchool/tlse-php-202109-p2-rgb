<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public function selectByGenre(int $id)
    {
        $statement = $this->pdo->query("SELECT * FROM genre JOIN game_genre ON id=genre_id WHERE id=$id");
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllGamesFromCategoryId(int $id)
    {
        $statement = $this->pdo->query("SELECT game.name, game.picture, game_id, genre_id FROM game " .
            "RIGHT JOIN game_genre ON game.id=game_id " .
            "RIGHT JOIN genre ON genre.id=genre_id " . 
            "WHERE genre_id=$id"
        );
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
