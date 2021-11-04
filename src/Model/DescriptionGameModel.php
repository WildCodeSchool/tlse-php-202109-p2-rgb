<?php

namespace App\Model;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function selectLikeById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "SELECT `like`, game_id FROM " . static::TABLE . " RIGHT JOIN `like` ON id=game_id where `like`='like'"
        );
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
