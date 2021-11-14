<?php

namespace App\Model;

use PDO;

class UserConnectionModel extends AbstractManager
{

    /**
     * cleanData
     *
     * @param  string $data
     * @return string
     */
    public function cleanData(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * errorsInForm
     *
     * @param  array $data
     * @return array
     */
    public function errorsInForm(array $data): array
    {
        $errors = [];

        foreach ($data as $key => $information) {
            switch ($key) {
                case 'nickname':
                    $key = "pseudo";
                    break;
                case 'passwordUser':
                    $key = "mot de passe";
                    break;
                case 'userMail':
                    $key = "email";
                    break;
                default:
                    break;
            }
            if (empty($information)) {
                $errors[$key] = "Le champ $key est requis";
            } elseif ($key === "email") {
                if (filter_var($information, FILTER_VALIDATE_EMAIL) === false) {
                    $errors[$key] = "Veuillez saisir une adresse mail valide";
                }
            }
        }
        return $errors;
    }

    public function isConnected(): bool
    {
        return isset($_SESSION['username']);
    }

    /**
     * isRegistered
     *
     * @param  array $data
     * @return array|false
     */
    public function isRegistered(array $data)
    {
        $connectionDB = new Connection();
        $pdo = $connectionDB->getPdoConnection();
        $query =
            "SELECT `nickname`, `password`
            FROM `user`
            WHERE  `nickname` = :nickname";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':nickname', $data['nickname'], \PDO::PARAM_STR);
        $statement->execute();
        $isRegistered = $statement->fetch(\PDO::FETCH_ASSOC);
        return $isRegistered;
    }

    public function saveUser(array $data)
    {
        $connectionDB = new Connection();
        $pdo = $connectionDB->getPdoConnection();
        $passwordUser = $this->cleanData($data['passwordUser']);
        $passwordUser = password_hash($passwordUser, PASSWORD_DEFAULT);
        $query =
            "INSERT INTO `rgb_team_wild`.`user` (`nickname`, `password`, `mail`)
            VALUES (:nickname, :passwordUser, :mail);";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':nickname', $data['nickname'], \PDO::PARAM_STR);
        $statement->bindValue(':passwordUser', $passwordUser, \PDO::PARAM_STR);
        $statement->bindValue(':mail', $data['userMail'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getUserId()
    {
        $statement = $this->pdo->prepare("SELECT * from user where nickname = :username");
        $statement->bindValue(":username", $_SESSION['username'], PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();
        return intval($statement['id']);
    }
}
