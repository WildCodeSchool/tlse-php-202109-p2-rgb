<?php

require_once __DIR__ . '/vendor/autoload.php';

if (getenv('ENV') === false) {
    require_once __DIR__ . '/config/debug.php';
    require_once __DIR__ . '/config/db.php';
}
require_once __DIR__ . '/config/config.php';

if (
    !defined('DB_HOST')
    || !defined('DB_NAME')
    || !defined('DB_USER')
    || !defined('DB_PASSWORD')
    || !defined('DB_DUMP_PATH')
) {
    die('Constants not found');
}
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . '; charset=utf8',
        DB_USER,
        DB_PASSWORD
    );

    $pdo->exec('DROP DATABASE IF EXISTS ' . DB_NAME);
    $pdo->exec('CREATE DATABASE ' . DB_NAME);
    $pdo->exec('USE ' . DB_NAME);

    if (is_file(DB_DUMP_PATH) && is_readable(DB_DUMP_PATH)) {
        $sql = file_get_contents(DB_DUMP_PATH);
        $statement = $pdo->prepare($sql);
        $statement->execute();
    } else {
        echo DB_DUMP_PATH . ' file does not exist';
    }
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
