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
        if (isset($_GET['user'])) {
            $user = $_GET['user'];
        } else {
            $user = $_SESSION['username'];
        }

        $statement = $this->pdo->prepare("SELECT * from user where nickname = :username");
        $statement->bindValue(":username", $user, PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();
        return intval($statement['id']);
    }

    public function getGameId()
    {
        $statement = $this->pdo->prepare(
            "SELECT id
            FROM game
            WHERE id=:id"
        );
        $statement->bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        $statement->execute();
        $statement = $statement->fetch();
        return intval($statement['id']);
    }

    public function insertIntoComment($commentaire, $getGameId, $getUserId)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO `comment` (content, date_submitted, game_id, `user_id`)
        VALUES (:commentaire, :date, :gameId, :userId)"
        );
        $statement->bindValue(":commentaire", $commentaire, PDO::PARAM_STR);
        $statement->bindValue(":date", date('Y-m-d'), PDO::PARAM_STR);
        $statement->bindValue(":gameId", $getGameId, PDO::PARAM_INT);
        $statement->bindValue(":userId", $getUserId, PDO::PARAM_INT);
        $statement->execute();
    }
    public function selectAllCommentsByGame()
    {
        $statement = $this->pdo->prepare(
            "SELECT nickname, avatar, content, date_submitted, game_id, `user_id`
            FROM `user`
            JOIN `comment`
            ON `user`.id=`user_id`
            WHERE game_id=:gameId
            ORDER BY date_submitted ASC"
        );
        $statement->bindValue(":gameId", $_GET['id'], PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
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
            80 => 'Fantastique',
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
                    return [$value, 'positive', $likes];
                } elseif ($like > -10) {
                    return [$value, 'neutral', $likes];
                } else {
                    return [$value, 'negative', $likes];
                }
            }
        }
        return ['Conquistador', 'negative', $likes];
    }

    public function selectLikeById(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT count(`like`) as 'count', `like` FROM `like`  WHERE :id = game_id GROUP BY `like`"
        );
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $this->getLikeScore($statement->fetchAll(PDO::FETCH_ASSOC));
    }
}
