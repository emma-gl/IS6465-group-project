<?php
$followedRestaurants = [
    [
        'name' => 'Olive & Ember',
        'cuisine' => 'Italian',
        'rating' => '4.8',
    ],
    [
        'name' => 'Harborlight Kitchen',
        'cuisine' => 'Seafood',
        'rating' => '4.4',
    ],
    [
        'name' => 'Cedar Bowl Noodle Bar',
        'cuisine' => 'Noodles',
        'rating' => '4.5',
    ],
];

$reviews = [
    [
        'restaurant' => 'Juniper Street Tacos',
        'rating' => '5',
        'date' => 'October 18, 2026',
        'text' => 'Fresh tortillas and bright salsa made this a great lunch. The roasted mushroom tacos were especially good.',
    ],
    [
        'restaurant' => 'Maple & Main Brunch House',
        'rating' => '4',
        'date' => 'September 29, 2026',
        'text' => 'Relaxed atmosphere, generous portions, and excellent coffee. The blueberry pancakes were a highlight.',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <h1>Account Info</h1>
        <p class="intro">A snapshot of your restaurant follows and reviews.</p>

        <section class="account-section" aria-labelledby="followed-heading">
            <h2 id="followed-heading">Restaurants You Follow</h2>
            <ul class="followed-list">
                <?php foreach ($followedRestaurants as $restaurant): ?>
                    <li class="followed-item">
                        <div>
                            <h3><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p><?= htmlspecialchars($restaurant['cuisine'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <span class="rating" aria-label="Rated <?= htmlspecialchars($restaurant['rating'], ENT_QUOTES, 'UTF-8') ?> out of 5">
                            ★ <?= htmlspecialchars($restaurant['rating'], ENT_QUOTES, 'UTF-8') ?> / 5
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="account-section" aria-labelledby="reviews-heading">
            <h2 id="reviews-heading">Your Reviews</h2>
            <div class="review-list">
                <?php foreach ($reviews as $review): ?>
                    <article class="review-item">
                        <div class="review-heading">
                            <h3><?= htmlspecialchars($review['restaurant'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <span class="rating" aria-label="Rated <?= htmlspecialchars($review['rating'], ENT_QUOTES, 'UTF-8') ?> out of 5">
                                <?= str_repeat('★', (int) $review['rating']) ?><?= str_repeat('☆', 5 - (int) $review['rating']) ?>
                                <?= htmlspecialchars($review['rating'], ENT_QUOTES, 'UTF-8') ?> / 5
                            </span>
                        </div>
                        <p class="review-date"><?= htmlspecialchars($review['date'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="review-text"><?= htmlspecialchars($review['text'], ENT_QUOTES, 'UTF-8') ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>