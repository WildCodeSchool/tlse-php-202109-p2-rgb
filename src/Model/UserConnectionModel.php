<?php

namespace App\Model;

class UserConnectionModel
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
            if (empty($information)) {
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
                $errors[$key] = "Le champ $key est requis";
            } elseif ($key === "userMail") {
                if (filter_var($information, FILTER_VALIDATE_EMAIL) === false) {
                    $errors[$key] = "Veuillez saisir une adresse mail valide";
                }
            }
        }
        return $errors;
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
}
