<?php
function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $path = __DIR__ . '/../database/restaurants.db';

        if (!file_exists($path)) {
            throw new RuntimeException(
                'Database not found. From FoodReviewApp/database run: '
                . 'Get-Content schema.sql | sqlite3 restaurants.db; Get-Content seed.sql | sqlite3 restaurants.db'
            );
        }

        $pdo = new PDO('sqlite:' . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    return $pdo;
}

function parseId($value): ?int
{
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}
