<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public function selectByGenre(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT *
            FROM genre
            JOIN game_genre
            ON id=genre_id
            WHERE id=:id"
        );
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAllGamesFromCategoryId(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT `name`, picture, game_id, genre_id
            FROM game
            RIGHT JOIN game_genre
            ON id=game_id
            WHERE :id=genre_id;"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllCategoryFromGameId(int $id)
    {
        $statement = $this->pdo->prepare(
            "SELECT genre_id
            FROM game_genre
            WHERE :id=game_id"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectNameByTagId($id)
    {
        $statement = $this->pdo->prepare(
            "SELECT `name`
            FROM genre
            WHERE :id=id"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

//     public function selectgameByID($id)
//     {
//         $statement = $this->pdo->prepare(
//             "SELECT game_id
//             FROM game_genre
//             WHERE genre_id=:id"
//         );
//         $statement->bindValue(":id", $id, PDO::PARAM_INT);
//         $statement->execute();
//         return $statement->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function selectCategoriesByNameIdTag($genreId)
//     {
//         $statement = $this->pdo->prepare(
//             "SELECT g.name, gr.name, game_id, genre_id
//             FROM game_genre
//             JOIN genre
//             AS gr
//             ON gr.id=genre_id
//             JOIN game
//             AS g
//             ON g.id=game_id
//             WHERE game_id=:genre_id"
//         );
//         $statement->bindValue(":genre_id", $genreId, PDO::PARAM_INT);
//         $statement->execute();
//         return $statement->fetchAll(PDO::FETCH_ASSOC);
//     }
}
