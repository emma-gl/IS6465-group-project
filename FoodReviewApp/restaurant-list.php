<?php
require_once 'includes/auth.php';
require_once 'includes/restaurants.php';

$sortOptions = [
    'rating-desc' => 'Highest rating',
    'rating-asc' => 'Lowest rating',
    'followers-desc' => 'Most followers',
    'followers-asc' => 'Fewest followers',
];

$sort = $_GET['sort'] ?? 'rating-desc';
if (!is_string($sort) || !isset($sortOptions[$sort])) {
    $sort = 'rating-desc';
}

[$sortField, $sortDirection] = explode('-', $sort);
$sortedRestaurants = getRestaurants($sortField, $sortDirection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <a class="back-link" href="landing-page.php">← Back to home</a>
        <h1>Browse restaurants</h1>
        <p class="intro">Explore local spots and see what diners are saying.</p>

        <div class="list-toolbar">
            <form class="sort-form" method="get" action="">
                <label for="sort">Sort by</label>
                <select id="sort" name="sort" onchange="this.form.submit()">
                    <?php foreach ($sortOptions as $value => $label): ?>
                        <option value="<?= $value ?>"<?= $value === $sort ? ' selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <noscript><button class="secondary-button" type="submit">Sort</button></noscript>
            </form>
            <?php if (canAddRestaurant()): ?>
                <a class="details-button" href="restaurant-add.php">Add a restaurant</a>
            <?php endif; ?>
        </div>

        <section class="restaurant-list" aria-label="Restaurants">
            <?php if (count($sortedRestaurants) === 0): ?>
                <p class="intro">No restaurants yet</p>
            <?php endif; ?>
            <?php foreach ($sortedRestaurants as $restaurant): ?>
                <article class="restaurant-card">
                    <div class="restaurant-card-info">
                        <h2><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p><?= htmlspecialchars($restaurant['cuisine'] . ' · ' . $restaurant['price_range'] . ' · ' . $restaurant['city'], ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="restaurant-stats">
                            <span class="rating" aria-label="Rating: <?= formatRating($restaurant['rating']) ?>">
                                <?= ratingStars($restaurant['rating']) ?> <?= formatRating($restaurant['rating']) ?>
                            </span>
                            <span class="followers"><?= number_format($restaurant['followers']) ?> follower<?= (int) $restaurant['followers'] === 1 ? '' : 's' ?></span>
                        </div>
                    </div>
                    <a class="details-button" href="restaurant-details.php?restaurant=<?= (int) $restaurant['id'] ?>">View Details</a>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
