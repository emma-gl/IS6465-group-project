<?php
require_once 'includes/auth.php';
require_once 'includes/restaurants.php';
require_once 'includes/reviews.php';

requireLogin();

$reviewId = parseId($_GET['id'] ?? null);
$review = $reviewId === null ? null : getReview($reviewId);
$restaurant = $review === null ? null : getRestaurant((int) $review['restaurant_id']);

if ($review === null || $restaurant === null) {
    http_response_code(404);
} elseif (!canEditReview($review)) {
    denyAccess();
} else {
    $foodItems = getFoodItems((int) $review['restaurant_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <section class="restaurant-details">
            <?php if ($review === null || $restaurant === null): ?>
                <h1>Review not found</h1>
                <p class="intro">Choose a review from your Account Info page to edit it.</p>
                <a class="details-button" href="account-info.php">Back to account info</a>
            <?php else: ?>
                <?php $accountUrl = 'account-info.php'; ?>
                <a class="back-link" href="<?= htmlspecialchars($accountUrl, ENT_QUOTES, 'UTF-8') ?>">← Back to account info</a>
                <h1>Edit your review</h1>
                <p class="intro"><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></p>

                <form class="crud-form" method="post" action="">
                    <input type="hidden" name="review_id" value="<?= $reviewId ?>">

                    <label for="food-item">Food item</label>
                    <select id="food-item" name="food_item_id" required>
                        <?php foreach ($foodItems as $foodItem): ?>
                            <option value="<?= (int) $foodItem['id'] ?>"<?= (int) $foodItem['id'] === (int) $review['food_item_id'] ? ' selected' : '' ?>><?= htmlspecialchars($foodItem['name'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php $selectedRating = (int) $review['rating']; require 'includes/star-input.php'; ?>

                    <label for="comment">Your review</label>
                    <textarea id="comment" name="comment" rows="5"><?= htmlspecialchars($review['comment'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

                    <div class="page-actions">
                        <button class="follow-button" type="button">Save changes</button>
                        <a class="secondary-button" href="<?= htmlspecialchars($accountUrl, ENT_QUOTES, 'UTF-8') ?>">Cancel</a>
                    </div>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
