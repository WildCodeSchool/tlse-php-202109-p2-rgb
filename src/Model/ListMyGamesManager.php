<?php

namespace App\Model;

use PDO;

class ListMyGamesManager extends AbstractManager
{

    public function selectByUserId()
    {
        $statement = $this->pdo->query(
            "SELECT *
            FROM `user`"
        );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
