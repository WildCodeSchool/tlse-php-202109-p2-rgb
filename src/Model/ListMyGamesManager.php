<?php

namespace App\Model;

use PDO;

class ListMyGamesManager extends AbstractManager
{
    public function selectByUserId(int $id)
    {
        $statement = $this->pdo->query(
            "SELECT user_id 
            FROM list_user 
            WHERE user_id=$id"
        );
        return  $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllFromGameOnListUser(int $id)
    {
        $statement = $this->pdo->query(
            "SELECT * 
            FROM game 
            JOIN list_user 
            ON id=$id"
        );
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
