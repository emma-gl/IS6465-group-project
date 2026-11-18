<?php
require_once __DIR__ . '/db.php';

$cuisineOptions = ['Italian', 'Mexican', 'Seafood', 'Brunch', 'Noodles', 'American', 'Asian', 'Other'];
$priceRangeOptions = ['$', '$$', '$$$', '$$$$'];

const RESTAURANT_SELECT = '
    SELECT r.restaurant_id AS id,
           r.name,
           r.cuisine_type AS cuisine,
           r.price_range,
           r.address,
           r.city,
           r.phone,
           r.avg_rating AS rating,
           (SELECT COUNT(*) FROM follow f WHERE f.restaurant_id = r.restaurant_id) AS followers
    FROM restaurants r';

function getRestaurants(string $sortField = 'rating', string $sortDirection = 'desc'): array
{
    $column = $sortField === 'followers' ? 'followers' : 'rating';
    $direction = $sortDirection === 'asc' ? 'ASC' : 'DESC';

    return db()->query(RESTAURANT_SELECT . " ORDER BY $column $direction, r.name")->fetchAll();
}

function getRestaurant(int $restaurantId): ?array
{
    $statement = db()->prepare(RESTAURANT_SELECT . ' WHERE r.restaurant_id = ?');
    $statement->execute([$restaurantId]);
    return $statement->fetch() ?: null;
}

function getRestaurantsByIds(array $restaurantIds): array
{
    if (count($restaurantIds) === 0) {
        return [];
    }

    $placeholders = implode(', ', array_fill(0, count($restaurantIds), '?'));
    $statement = db()->prepare(RESTAURANT_SELECT . " WHERE r.restaurant_id IN ($placeholders) ORDER BY r.name");
    $statement->execute(array_values($restaurantIds));
    return $statement->fetchAll();
}

function getFollowedRestaurants(int $userId): array
{
    $statement = db()->prepare(
        RESTAURANT_SELECT . ' JOIN follow fl ON fl.restaurant_id = r.restaurant_id WHERE fl.user_id = ? ORDER BY r.name'
    );
    $statement->execute([$userId]);
    return $statement->fetchAll();
}

function isFollowing(int $userId, int $restaurantId): bool
{
    $statement = db()->prepare('SELECT 1 FROM follow WHERE user_id = ? AND restaurant_id = ?');
    $statement->execute([$userId, $restaurantId]);
    return $statement->fetchColumn() !== false;
}

function getFoodItems(int $restaurantId): array
{
    $statement = db()->prepare(
        'SELECT food_item_id AS id, name FROM food_item WHERE restaurant_id = ? ORDER BY food_item_id'
    );
    $statement->execute([$restaurantId]);
    return $statement->fetchAll();
}

//converts rating into stars
function ratingStars($rating): string
{
    $fullStars = max(0, min(5, (int) round((float) $rating)));
    return str_repeat('★', $fullStars) . str_repeat('☆', 5 - $fullStars);
}

function formatRating($rating): string
{
    return $rating === null ? 'No ratings yet' : number_format((float) $rating, 1) . ' / 5';
}

function restaurantInitials(string $name): string
{
    $words = array_filter(explode(' ', $name), fn ($word) => ctype_alpha(substr($word, 0, 1)));
    $letters = array_map(fn ($word) => strtoupper(substr($word, 0, 1)), array_slice($words, 0, 2));
    return implode('', $letters);
}
