<?php

namespace App\Model;

use PDO;

class ListMyGamesManager extends AbstractManager
{

    public function selectByUserNickname()
    {
        $statement = $this->pdo->prepare(
            "SELECT nickname
            FROM `user
            WHERE nickname=nickname"
        );
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
