<?php

namespace App\Model;

use PDO;

class DescriptionGameModel extends AbstractManager
{
    public const TABLE = 'game';

    public function gameIsAlreadyInUserList($idGame, $idUser)
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
    public function insertIntoComment($commentaire)
    {
        $getGameId = $this->getGameId();
        $getUserId = $this->getUserId();
        $statement = $this->pdo->prepare(
            "INSERT INTO `comment` (content, date_submitted, game_id, user_id) 
        VALUES (:commentaire, :date, " . $getGameId . ", " . $getUserId . ")"
        );
        $statement->bindValue(":commentaire", $commentaire, PDO::PARAM_STR);
        $statement->bindValue(":date", date('Y-m-d'), PDO::PARAM_STR);
        $statement->execute();
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
            $reviews = [
                80 => 'Tacos',
                50 => 'Très Positif',
                30 => 'Positif',
                10 => 'Assez Positif',
                -10 => 'Moyen',
                -30 => 'Négatif',
                -50 => 'Très négatif'
            ];
            $like = (round(($likes[1]['count'] - $likes[0]['count']) / ($likes[0]['count'] + $likes[1]['count']) * 100));
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
