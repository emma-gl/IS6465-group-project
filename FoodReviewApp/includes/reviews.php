<?php
require_once __DIR__ . '/db.php';

const REVIEW_SELECT = '
    SELECT v.review_id AS id,
           v.rating,
           v.comment,
           v.created_at,
           v.food_item_id,
           f.name AS food_item,
           f.restaurant_id,
           r.name AS restaurant_name,
           v.user_id,
           u.first_name AS user
    FROM review v
    JOIN food_item f ON f.food_item_id = v.food_item_id
    JOIN restaurants r ON r.restaurant_id = f.restaurant_id
    JOIN users u ON u.user_id = v.user_id';

function getReviewsForRestaurant(int $restaurantId): array
{
    $statement = db()->prepare(REVIEW_SELECT . ' WHERE f.restaurant_id = ? ORDER BY v.created_at DESC');
    $statement->execute([$restaurantId]);
    return $statement->fetchAll();
}

function getReviewsByUser(int $userId): array
{
    $statement = db()->prepare(REVIEW_SELECT . ' WHERE v.user_id = ? ORDER BY v.created_at DESC');
    $statement->execute([$userId]);
    return $statement->fetchAll();
}

function getReview(int $reviewId): ?array
{
    $statement = db()->prepare(REVIEW_SELECT . ' WHERE v.review_id = ?');
    $statement->execute([$reviewId]);
    return $statement->fetch() ?: null;
}

//converts timestamp into a readable date format
function formatReviewDate(string $timestamp): string
{
    return date('F j, Y', strtotime($timestamp));
}
