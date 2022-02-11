<?php

namespace App\Model;

use PDO;

class HomeModel extends AbstractManager
{
    public const TABLE = 'genre';

    public function getBestGamesByLikes()
    {
        $statement = $this->pdo->prepare(
            "SELECT game_id, `like`, game.picture, 
            SUM(case when `like` = `like` then 1 end) as sumlike
            FROM game
            JOIN `like`
            ON game.id=game_id
            GROUP BY game_id, (`like`)
            ORDER BY SUM(`like`) desc
            LIMIT 3;"
        );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
