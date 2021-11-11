<?php

namespace App\Model;

use PDO;

class ListMyGamesManager extends AbstractManager
{

    public function getAllFromListUser($userId)
    {
        $statement = $this->pdo->prepare(
            "SELECT * 
            FROM game 
            JOIN list_user 
            ON user_id=:id 
            WHERE game.id=game_id"
            );
        $statement->bindValue(":id", $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
        
    }

}
