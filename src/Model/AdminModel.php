<?php

namespace App\Model;

use PDO;

class AdminModel extends AbstractManager
{
    public function addGameOnDatabase(array $informations)
    {
        $releaseDate = $informations['release_date'];
        $query =
        "INSERT INTO `game` (`name`, `date_release`, `description`, `picture`)
        VALUE (:titleGame, :releaseDate, :descriptionGame, :picture);";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':titleGame', $informations['name'], PDO::PARAM_STR);
        $statement->bindValue(':releaseDate', $releaseDate, PDO::PARAM_STR);
        $statement->bindValue(':descriptionGame', $informations['description'], PDO::PARAM_STR);
        $statement->bindValue(':picture', $_FILES['picture']['name'], PDO::PARAM_STR);
        $statement->execute();
    }

    public function addGameCategories(array $informations)
    {
        $gameID = intval($this->getIdOfGame($informations["name"])['id']);
        $categories = $informations["category"];
        foreach ($categories as $category) {
            $category = intval($category);
            $query = "INSERT INTO `game_genre` (`game_id`, `genre_id`) VALUES ($gameID, $category);";
            $this->pdo->query($query);
        }
    }

    public function getIdOfGame($titleGame)
    {
        $query = "SELECT `id` FROM `game` WHERE `name` = :titleGame;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":titleGame", $titleGame, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
