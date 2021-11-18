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

    /**
     * isConnected
     *
     * @return bool
     */
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

    /**
     * saveUser
     *
     * @param  array $data
     * @return void
     */
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

    /**
     * getUserId
     *
     * @return int|false
     */
    public function getUserId()
    {
        $statement = $this->pdo->prepare("SELECT * from user where nickname = :username");
        $statement->bindValue(":username", $_SESSION['username'], PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();
        return intval($statement['id']);
    }

    /**
     * getUserAvatar
     *
     * @return array|false
     */
    public function getUserAvatar()
    {

        $query = "SELECT `avatar` FROM `user` WHERE user.id = :userId;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":userId", $this->getUserId(), PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch()['avatar'];
    }

    /**
     * updateUserProfile
     *
     * @return void
     */
    public function updateUserProfile()
    {
        $uploadDirectory = dirname(__DIR__, 2) . "/public/assets/images/pictures_game/avatar/uploads/";
        $uploadFile = $uploadDirectory . basename($_FILES['avatar']['name']);
        $sourceDirectory = '/assets/images/pictures_game/avatar/uploads/';
        $sourceFile = $sourceDirectory . basename($_FILES['avatar']['name']);
        $firstname = trim(htmlentities($_POST['name']));
        $errors = [];
        $verification = $this->verifyData();
        if (!empty($verification)) {
            foreach ($verification as $error) {
                $errors[] = $error;
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $_SESSION['errors'][] = $error;
            }
        }

        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);

        if ($_SESSION['username'] !== $firstname) {
            $_SESSION['username'] = $firstname;
        }

        if ($sourceFile != $sourceDirectory) {
            $_SESSION['avatar'] = $sourceFile;
        }

        $_SESSION['file'] = $_FILES;
        $query = "UPDATE `user` SET `nickname` = :nickname, `avatar` = :avatar WHERE `id` = :userId;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":nickname", $_SESSION['username'], PDO::PARAM_STR);
        $statement->bindValue(":avatar", $_SESSION['avatar'], PDO::PARAM_STR);
        $statement->bindValue(":userId", $_SESSION['userId'], PDO::PARAM_INT);
        $statement->execute();
        header("Location:myProfile");
    }

    /**
     * verifyData
     *
     * @return array
     */
    public function verifyData(): array
    {
        $extensionFile = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extensionAuthorized = ['jpg', 'jpeg', 'png', 'svg', 'webp', 'image/jpeg'];
        $maxFileSize = 2_000_000;
        $errors = [];

        if (!empty($extensionFile)) {
            if (!in_array($extensionFile, $extensionAuthorized)) {
                $errors[] = 'Veuillez choisir un fichier de type jpg, jpeg, png, webp ou svg';
            }
        }

        if (file_exists($_FILES['avatar']['tmp_name'])) {
            if (filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
                $errors[] = "Votre fichier est trop volumineux... Il ne doit pas dépasser 1Mo";
            }
        } else {
            if ($_FILES['avatar']['error'] === 1) {
                $errors[] = "Votre fichier est beaucoup trop volumineux... Il ne doit pas dépasser 1Mo";
            }
        }

        return $errors;
    }
}
