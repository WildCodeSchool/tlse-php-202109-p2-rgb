<?php

namespace App\Model;

use PDO;

class GameCategoryManager extends AbstractManager
{
    public const TABLE = 'game_genre';

    public function selectOneByGenre_id(int $id)
    {
        $statement = $this->pdo->query("SELECT * from " . static::TABLE .  " WHERE genre_id = $id");         
        $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $genres;
    }
}