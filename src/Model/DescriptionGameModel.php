<?php

namespace App\Model;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function selectLikeById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "SELECT count(`like`) as 'count', `like` FROM `like`  WHERE :id = game_id GROUP BY `like`"
        );
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $likes = $statement->fetchAll(\PDO::FETCH_ASSOC);
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
