<?php

namespace App\Model;

use PDO;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function addToMyList($idGame)
    {
        $userId = $this->pdo->prepare("SELECT * from user where nickname = :username");
        $userId->bindValue(":username", $_SESSION['username'], PDO::PARAM_STR);
        $userId->execute();
        $statement1 = $userId->fetch();
        $userId = intval($statement1['id']);
        var_dump($statement1);
        $statement = $this->pdo->prepare(
            "INSERT INTO list_user (game_id, `user_id`)
            VALUES (:idGame, " . $userId . ")"
        );
        $statement->bindValue(":idGame", $idGame, PDO::FETCH_ASSOC);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function selectLikeById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "SELECT count(`like`) as 'count', `like` FROM `like`  WHERE :id = game_id GROUP BY `like`"
        );
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();

        $likes = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($likes)) {
            return $likes;
        } else {
            $reviews = [ 80 => 'Tacos',
                50 => 'Très Positif',
                30 => 'Positif',
                10 => 'Assez Positif',
                -10 => 'Moyen',
                -30 => 'Négatif',
                -50 => 'Très négatif'
            ];
            $like = (
                round(($likes[1]['count'] - $likes[0]['count']) / ($likes[0]['count'] + $likes[1]['count']) * 100)
            );
            foreach ($reviews as $key => $value) {
                if ($like >= $key) {
                    if ($like >= 10) {
                        return [$value, 'green', $likes];
                    } elseif ($like < 10 && $like > -10) {
                        return [$value, 'yellow', $likes];
                    } else {
                        return [$value, 'red', $likes];
                    }
                } elseif ($like < -50) {
                    return ['Conquistador', 'red', $likes];
                }
            }
        }
    }
}
