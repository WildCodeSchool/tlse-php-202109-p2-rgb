<?php

namespace App\Model;

use PDO;

class GameCategoryManager extends AbstractManager
{
    public const TABLE = 'game_genre';

    public function selectAllById(int $id)
    {
        $statement = $this->pdo->query("SELECT * from " . static::TABLE .  " WHERE genre_id = $id");         
        $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $genres;
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->query("SELECT DISTINCT genre_id from " . static::TABLE .  " WHERE genre_id = $id");         
        $genre = $statement->fetch(PDO::FETCH_ASSOC);

        return $genre;
    }
}