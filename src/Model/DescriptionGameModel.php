<?php

namespace App\Model;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function selectLikeById(int $id): ?float
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "SELECT count(`like`) as 'count', `like` FROM `like`  WHERE :id = game_id GROUP BY `like`"
        );
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $likes = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return empty($likes) ? null : (round(($likes[1]['count'] - $likes[0]['count']) / ($likes[0]['count'] + $likes[1]['count']) * 100));
    }
}
