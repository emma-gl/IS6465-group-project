<?php
require_once 'includes/restaurants.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Restaurant | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <section class="restaurant-details">
            <a class="back-link" href="restaurant-list.php">← Back to restaurants</a>
            <h1>Add a restaurant</h1>
            <p class="intro">Share a new restaurant so diners can start reviewing it.</p>

            <form class="crud-form" method="post" action="">
                <label for="name">Restaurant name</label>
                <input type="text" id="name" name="name" required>

                <label for="cuisine">Type of cuisine</label>
                <select id="cuisine" name="cuisine" required>
                    <option value="">Select a cuisine</option>
                    <?php foreach ($cuisineOptions as $cuisine): ?>
                        <option value="<?= htmlspecialchars($cuisine, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($cuisine, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="price-range">Price range</label>
                <select id="price-range" name="price_range" required>
                    <option value="">Select a price range</option>
                    <?php foreach ($priceRangeOptions as $priceRange): ?>
                        <option value="<?= htmlspecialchars($priceRange, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($priceRange, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"></textarea>

                <div class="page-actions">
                    <button class="follow-button" type="button">Add restaurant</button>
                    <a class="secondary-button" href="restaurant-list.php">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
