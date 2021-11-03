<?php

namespace App\Model;

use PDO;

class GameCategoryManager extends AbstractManager
{
    public const TABLE = 'game_genre';

    public function selectByGenre(int $id)
    {
        $statement = $this->pdo->prepare("SELECT DISTINCT name FROM genre JOIN game_genre ON id=genre_id WHERE id=$id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllGamesFromCategoryId(int $id)
    {
        $statement = $this->pdo->query("SELECT name, picture, game_id, genre_id FROM game RIGHT JOIN game_genre ON id=game_id WHERE $id=genre_id");         
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
