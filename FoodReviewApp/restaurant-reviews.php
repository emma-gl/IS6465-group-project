<?php
require_once 'includes/restaurants.php';
require_once 'includes/reviews.php';

$restaurantId = $_GET['restaurant'] ?? '';
$restaurant = is_string($restaurantId) ? ($restaurants[$restaurantId] ?? null) : null;

if ($restaurant === null) {
    http_response_code(404);
    $restaurantReviews = [];
} else {
    $restaurantReviews = array_filter($reviews, fn ($review) => $review['restaurant'] === $restaurantId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $restaurant === null ? 'Restaurant not found' : htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') . ' Reviews' ?> | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <?php if ($restaurant === null): ?>
            <section class="restaurant-details">
                <h1>Restaurant not found</h1>
                <p class="intro">Choose a restaurant from the list to see its reviews.</p>
                <a class="details-button" href="restaurant-list.php">Back to restaurants</a>
            </section>
        <?php else: ?>
            <article class="restaurant-details">
                <a class="back-link" href="restaurant-details.php?restaurant=<?= urlencode($restaurantId) ?>">← Back to restaurant details</a>

                <div class="restaurant-layout">
                    <div class="restaurant-image" role="img" aria-label="<?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?> logo placeholder">
                        <span><?= restaurantInitials($restaurant['name']) ?></span>
                        <small>Photo coming soon</small>
                    </div>

                    <div class="restaurant-info">
                        <h1><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                        <div class="restaurant-stats">
                            <span class="rating" aria-label="Average rating <?= $restaurant['rating'] ?> out of 5">
                                <?= ratingStars($restaurant['rating']) ?> <?= $restaurant['rating'] ?> / 5
                            </span>
                            <span class="followers"><?= count($restaurantReviews) ?> review<?= count($restaurantReviews) === 1 ? '' : 's' ?></span>
                        </div>

                        <h2 class="section-label">Customer reviews</h2>
                        <?php if (count($restaurantReviews) === 0): ?>
                            <p class="intro">No reviews yet. Be the first to add one!</p>
                        <?php else: ?>
                            <div class="review-list">
                                <?php foreach ($restaurantReviews as $review): ?>
                                    <article class="review-item">
                                        <div class="review-heading">
                                            <h3><?= htmlspecialchars($review['food_item'], ENT_QUOTES, 'UTF-8') ?></h3>
                                            <span class="rating" aria-label="Rated <?= (int) $review['rating'] ?> out of 5">
                                                <?= ratingStars($review['rating']) ?> <?= (int) $review['rating'] ?> / 5
                                            </span>
                                        </div>
                                        <p class="review-date">
                                            By <?= htmlspecialchars($review['user'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($review['date'], ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                        <p class="review-text"><?= htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8') ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <form class="crud-form write-review" method="post" action="">
                    <h2 id="write-review">Write a review</h2>
                    <input type="hidden" name="restaurant" value="<?= htmlspecialchars($restaurantId, ENT_QUOTES, 'UTF-8') ?>">

                    <label for="food-item">Food item</label>
                    <select id="food-item" name="food_item" required>
                        <option value="">Select a food item</option>
                        <?php foreach ($restaurant['food_items'] as $foodItem): ?>
                            <option value="<?= htmlspecialchars($foodItem, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($foodItem, ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php $selectedRating = 0; require 'includes/star-input.php'; ?>

                    <label for="comment">Your review</label>
                    <textarea id="comment" name="comment" rows="5"></textarea>

                    <button class="follow-button" type="button">Submit review</button>
                </form>
            </article>
        <?php endif; ?>
    </main>
</body>
</html>
