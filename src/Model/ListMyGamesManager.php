<?php

namespace App\Model;

use PDO;

class ListMyGamesManager extends AbstractManager
{

    public function selectByUserNickname(string $nickname)
    {
        $statement = $this->pdo->prepare(
            "SELECT nickname
            FROM `user
            WHERE nickname=:nickname"
        );
        $statement->bindValue(':nickname', $nickname, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
