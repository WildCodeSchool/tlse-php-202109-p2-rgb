<?php

namespace App\Model;

use PDO;

class MyGamesManager extends AbstractManager
{
    public function selectByUserId(int $id)
    {
        $statement = $this->pdo->query("SELECT user_id FROM list_user WHERE user_id=$id");
        $userId = $statement->fetch(PDO::FETCH_ASSOC);
        return $userId;
    }
}
