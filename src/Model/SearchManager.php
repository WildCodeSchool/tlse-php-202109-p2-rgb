<?php

namespace App\Model;

class SearchManager extends AbstractManager
{
    public function selectByTag(string $id): ?array
    {
        $statement = $this->pdo->prepare("SELECT * FROM game WHERE game.name LIKE :id");
        $statement->bindValue('id', "%$id%", \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }
}
