<?php

namespace App\Model;

use PDO;
use App\Model\AbstractManager;

class DescritptionGameStatusModel extends AbstractManager
{
    public const TABLE = 'game';

    public function addStatusGameByUserId($status, $gameId, $userId)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO `list_user` (game_id, `user_id`, `status`)
            VALUES (:gameId, :userId, :`status`);"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->bindValue(":status", $status, PDO::PARAM_STR);
        $statement->execute();
    }

    public function updateStatusGameByUserId($status, $gameId, $userId)
    {
        $statement = $this->pdo->prepare(
            "UPDATE `list_user`
            SET `status` = :statusGame
            WHERE game_id = :gameId
            AND `user_id` = :userId;"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->bindValue(":statusGame", $status, PDO::PARAM_STR);
        $statement->execute();
    }

    public function selectGameStatusFromUserId(int $gameId, int $userId)
    {
        $statement = $this->pdo->prepare(
            "SELECT `status`
            FROM `list_user`
            WHERE :gameId = game_id
            AND :userId = `user_id`;"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
