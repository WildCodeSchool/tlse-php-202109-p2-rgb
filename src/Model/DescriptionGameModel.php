<?php

namespace App\Model;

use PDO;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function reviewGame(int $gameId, int $userId, string $review)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO `like` (game_id, `user_id`, `like`)
            VALUES (:gameId, :userId, :review);"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->bindValue(":review", $review, PDO::PARAM_STR);
        $statement->execute();
    }

    public function updateReviewGame(int $gameId, int $userId, string $review)
    {
        $statement = $this->pdo->prepare(
            "UPDATE `like`
            SET `like` = :review
            WHERE game_id = :gameId
            AND `user_id` = :userId;"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->bindValue(":review", $review, PDO::PARAM_STR);
        $statement->execute();
    }

    public function selectGameReviewFromUserId(int $gameId, int $userId)
    {
        $statement = $this->pdo->prepare(
            "SELECT `like`
            FROM `like`
            WHERE :gameId = game_id
            AND :userId = `user_id`;"
        );
        $statement->bindValue(":gameId", $gameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function gameIsAlreadyInUserList(int $idGame, int $idUser)
    {
        $statement = $this->pdo->prepare(
            "SELECT *
            FROM list_user
            where :idGame = game_id
            AND :idUser = `user_id`"
        );
        $statement->bindValue(":idGame", $idGame, PDO::PARAM_INT);
        $statement->bindValue(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $bool = $statement->fetch();
        return $bool === false ? false : true;
    }

    public function getUserId()
    {
        $statement = $this->pdo->prepare("SELECT * from user where nickname = :username");
        $statement->bindValue(":username", $_SESSION['username'], PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();
        return intval($statement['id']);
    }

    public function addToMyList($idGame)
    {
        $userId = $this->getUserId();
        $statement = $this->pdo->prepare(
            "INSERT INTO list_user (game_id, `user_id`)
            VALUES (:idGame, " . $userId . ")"
        );
        $statement->bindValue(":idGame", $idGame, PDO::FETCH_ASSOC);
        $statement->execute();
    }

    public function averageLikeCustom($likes)
    {
        if (isset($likes[1])) {
            return round(($likes[1]['count'] - $likes[0]['count']) / ($likes[0]['count'] + $likes[1]['count']) * 100);
        } else {
            return $likes[0]['like'] === 'like' ? $likes[0]['count'] * 100 : -$likes[0]['count'] * 100;
        }
    }

    public function getLikeScore($likes)
    {
        if (!$likes) {
            return $likes;
        }
        $reviews = [
            80 => 'Tacos',
            50 => 'Très Positif',
            30 => 'Positif',
            10 => 'Assez Positif',
            -10 => 'Moyen',
            -30 => 'Négatif',
            -50 => 'Très négatif'
        ];
        $like = $this->averageLikeCustom($likes);
        foreach ($reviews as $key => $value) {
            if ($like >= $key) {
                if ($like >= 10) {
                    return [$value, 'green', $likes];
                } elseif ($like > -10) {
                    return [$value, 'yellow', $likes];
                } else {
                    return [$value, 'red', $likes];
                }
            }
        }
        return ['Conquistador', 'red', $likes];
    }

    public function selectLikeById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "SELECT count(`like`) as 'count', `like` FROM `like`  WHERE :id = game_id GROUP BY `like`"
        );
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $this->getLikeScore($statement->fetchAll(PDO::FETCH_ASSOC));
    }
}
