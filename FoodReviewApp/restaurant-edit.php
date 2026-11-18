<?php
require_once 'includes/auth.php';
require_once 'includes/restaurants.php';

requireLogin();

$restaurantId = parseId($_GET['restaurant'] ?? null);
$restaurant = $restaurantId === null ? null : getRestaurant($restaurantId);

if ($restaurant === null) {
    http_response_code(404);
} elseif (!canManageRestaurant($restaurantId)) {
    denyAccess();
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
                <?php $detailsUrl = 'restaurant-details.php?restaurant=' . $restaurantId; ?>
                <a class="back-link" href="<?= htmlspecialchars($detailsUrl, ENT_QUOTES, 'UTF-8') ?>">← Back to restaurant</a>
                <h1>Edit <?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="intro">Update or correct this restaurant's information.</p>

                <form class="crud-form" method="post" action="">
                    <input type="hidden" name="restaurant" value="<?= $restaurantId ?>">

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

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?= htmlspecialchars($restaurant['address'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="<?= htmlspecialchars($restaurant['city'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($restaurant['phone'], ENT_QUOTES, 'UTF-8') ?>" required>

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
