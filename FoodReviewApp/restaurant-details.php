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
    <title><?= $restaurant === null ? 'Restaurant not found' : htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?> | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <?php if ($restaurant === null): ?>
            <section class="restaurant-details">
                <h1>Restaurant not found</h1>
                <p class="intro">Choose a restaurant from the list to see its details.</p>
                <a class="details-button" href="restaurant-list.php">Back to restaurants</a>
            </section>
        <?php else: ?>
            <article class="restaurant-details">
                <a class="back-link" href="restaurant-list.php">← Back to restaurants</a>
                <h1><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h1>

                <div class="restaurant-layout">
                    <div class="restaurant-image" role="img" aria-label="<?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?> logo placeholder">
                        <span><?= restaurantInitials($restaurant['name']) ?></span>
                        <small>Photo coming soon</small>
                    </div>

                    <div class="restaurant-info">
                        <p class="restaurant-meta">
                            <?= htmlspecialchars($restaurant['cuisine'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($restaurant['price_range'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="restaurant-description"><?= htmlspecialchars($restaurant['description'], ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="restaurant-stats">
                            <span class="rating" aria-label="Rated <?= $restaurant['rating'] ?> out of 5">
                                <?= ratingStars($restaurant['rating']) ?> <?= $restaurant['rating'] ?> / 5
                            </span>
                            <span class="followers"><?= number_format($restaurant['followers']) ?> followers</span>
                        </div>

                        <h2 class="section-label">Menu items</h2>
                        <ul class="menu-list">
                            <?php foreach ($restaurant['food_items'] as $foodItem): ?>
                                <li><?= htmlspecialchars($foodItem, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="page-actions">
                            <button class="follow-button" type="button" aria-pressed="false">Follow</button>
                            <a class="details-button" href="restaurant-reviews.php?restaurant=<?= urlencode($restaurantId) ?>">View reviews</a>
                        </div>
                    </div>
                </div>

                <section class="manage-section" aria-labelledby="manage-heading">
                    <h2 id="manage-heading">Manage restaurant (for restaurant owners only)</h2>
                    <div class="page-actions">
                        <a class="secondary-button" href="restaurant-edit.php?restaurant=<?= urlencode($restaurantId) ?>">Edit restaurant</a>
                        <button class="danger-button" type="button">Delete restaurant</button>
                    </div>
                </section>
            </article>
        <?php endif; ?>
    </main>
    <script>
        const followButton = document.querySelector('.follow-button');

        if (followButton) {
            followButton.addEventListener('click', () => {
                const isFollowing = followButton.getAttribute('aria-pressed') === 'true';
                followButton.setAttribute('aria-pressed', String(!isFollowing));
                followButton.textContent = isFollowing ? 'Follow' : 'Unfollow';
            });
        }
    </script>
</body>
</html>
