<?php
require_once 'includes/restaurants.php';

$restaurantId = $_GET['restaurant'] ?? '';
$restaurant = is_string($restaurantId) ? ($restaurants[$restaurantId] ?? null) : null;

if ($restaurant === null) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <section class="restaurant-details">
            <?php if ($restaurant === null): ?>
                <h1>Restaurant not found</h1>
                <p class="intro">Choose a restaurant from the list to edit its information.</p>
                <a class="details-button" href="restaurant-list.php">Back to restaurants</a>
            <?php else: ?>
                <?php $detailsUrl = 'restaurant-details.php?restaurant=' . urlencode($restaurantId); ?>
                <a class="back-link" href="<?= htmlspecialchars($detailsUrl, ENT_QUOTES, 'UTF-8') ?>">← Back to restaurant</a>
                <h1>Edit <?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="intro">Update or correct this restaurant's information.</p>

                <form class="crud-form" method="post" action="">
                    <input type="hidden" name="restaurant" value="<?= htmlspecialchars($restaurantId, ENT_QUOTES, 'UTF-8') ?>">

                    <label for="name">Restaurant name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="cuisine">Type of cuisine</label>
                    <select id="cuisine" name="cuisine" required>
                        <?php foreach ($cuisineOptions as $cuisine): ?>
                            <option value="<?= htmlspecialchars($cuisine, ENT_QUOTES, 'UTF-8') ?>"<?= $cuisine === $restaurant['cuisine'] ? ' selected' : '' ?>><?= htmlspecialchars($cuisine, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="price-range">Price range</label>
                    <select id="price-range" name="price_range" required>
                        <?php foreach ($priceRangeOptions as $priceRange): ?>
                            <option value="<?= htmlspecialchars($priceRange, ENT_QUOTES, 'UTF-8') ?>"<?= $priceRange === $restaurant['price_range'] ? ' selected' : '' ?>><?= htmlspecialchars($priceRange, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5"><?= htmlspecialchars($restaurant['description'], ENT_QUOTES, 'UTF-8') ?></textarea>

                    <div class="page-actions">
                        <button class="follow-button" type="button">Save changes</button>
                        <a class="secondary-button" href="<?= htmlspecialchars($detailsUrl, ENT_QUOTES, 'UTF-8') ?>">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
