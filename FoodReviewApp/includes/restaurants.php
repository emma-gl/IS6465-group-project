<?php
// dummy data shared for until the database is connected.
$restaurants = [
    'olive-ember' => [
        'name' => 'Olive & Ember',
        'cuisine' => 'Italian',
        'price_range' => '$$',
        'description' => 'A cozy neighborhood trattoria serving handmade pasta, wood-fired vegetables, and seasonal Italian favorites.',
        'rating' => 4.8,
        'followers' => 1240,
        'food_items' => ['Cacio e Pepe', 'Wood-Fired Margherita', 'Tiramisu'],
    ],
    'juniper-street-tacos' => [
        'name' => 'Juniper Street Tacos',
        'cuisine' => 'Mexican',
        'price_range' => '$',
        'description' => 'A lively taqueria known for slow-braised fillings, bright salsas, and fresh tortillas made throughout the day.',
        'rating' => 4.6,
        'followers' => 2015,
        'food_items' => ['Roasted Mushroom Tacos', 'Carnitas Tacos', 'Elote'],
    ],
    'harborlight-kitchen' => [
        'name' => 'Harborlight Kitchen',
        'cuisine' => 'Seafood',
        'price_range' => '$$$',
        'description' => 'A relaxed seafood restaurant featuring daily catches, crisp fish sandwiches, and a sunny waterfront patio.',
        'rating' => 4.4,
        'followers' => 860,
        'food_items' => ['Crispy Fish Sandwich', 'Clam Chowder', 'Catch of the Day'],
    ],
    'maple-main-brunch-house' => [
        'name' => 'Maple & Main Brunch House',
        'cuisine' => 'Brunch',
        'price_range' => '$$',
        'description' => 'An all-day brunch favorite with fluffy pancakes, hearty breakfast bowls, and locally roasted coffee.',
        'rating' => 4.7,
        'followers' => 1530,
        'food_items' => ['Blueberry Pancakes', 'Breakfast Bowl', 'House Latte'],
    ],
    'cedar-bowl-noodle-bar' => [
        'name' => 'Cedar Bowl Noodle Bar',
        'cuisine' => 'Noodles',
        'price_range' => '$$',
        'description' => 'A casual noodle shop dishing up rich broths, hand-pulled noodles, and customizable bowls with seasonal toppings.',
        'rating' => 4.5,
        'followers' => 975,
        'food_items' => ['Spicy Miso Ramen', 'Hand-Pulled Beef Noodles', 'Veggie Udon'],
    ],
];

$cuisineOptions = ['Italian', 'Mexican', 'Seafood', 'Brunch', 'Noodles', 'American', 'Asian', 'Other'];
$priceRangeOptions = ['$', '$$', '$$$', '$$$$'];

// Turns a rating like 4.4 into "★★★★☆".
function ratingStars($rating): string
{
    $fullStars = max(0, min(5, (int) round((float) $rating)));
    return str_repeat('★', $fullStars) . str_repeat('☆', 5 - $fullStars);
}

// Placeholder for a restaurant logo/menu photo: the first letters of the first two words.
function restaurantInitials(string $name): string
{
    $words = array_filter(explode(' ', $name), fn ($word) => ctype_alpha(substr($word, 0, 1)));
    $letters = array_map(fn ($word) => strtoupper(substr($word, 0, 1)), array_slice($words, 0, 2));
    return implode('', $letters);
}
