<?php
require_once 'includes/auth.php';
require_once 'includes/restaurants.php';

$restaurantId = parseId($_GET['restaurant'] ?? null);
$restaurant = $restaurantId === null ? null : getRestaurant($restaurantId);

if ($restaurant === null) {
    http_response_code(404);
} else {
    $foodItems = getFoodItems($restaurantId);
    $following = hasRole('Member') && isFollowing(currentUser()['id'], $restaurantId);
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
                        <p class="restaurant-description">
                            <?= htmlspecialchars($restaurant['address'] . ', ' . $restaurant['city'], ENT_QUOTES, 'UTF-8') ?><br>
                            <?= htmlspecialchars($restaurant['phone'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <div class="restaurant-stats">
                            <span class="rating" aria-label="Rating: <?= formatRating($restaurant['rating']) ?>">
                                <?= ratingStars($restaurant['rating']) ?> <?= formatRating($restaurant['rating']) ?>
                            </span>
                            <span class="followers"><?= number_format($restaurant['followers']) ?> follower<?= (int) $restaurant['followers'] === 1 ? '' : 's' ?></span>
                        </div>

                        <h2 class="section-label">Menu items</h2>
                        <?php if (count($foodItems) === 0): ?>
                            <p class="intro">No menu items yet.</p>
                        <?php else: ?>
                            <ul class="menu-list">
                                <?php foreach ($foodItems as $foodItem): ?>
                                    <li><?= htmlspecialchars($foodItem['name'], ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="page-actions">
                            <?php if (hasRole('Member')): ?>
                                <button class="follow-button" type="button" aria-pressed="<?= $following ? 'true' : 'false' ?>"><?= $following ? 'Unfollow' : 'Follow' ?></button>
                            <?php endif; ?>
                            <a class="details-button" href="restaurant-reviews.php?restaurant=<?= $restaurantId ?>">View reviews</a>
                        </div>
                    </div>
                </div>

                <?php if (canManageRestaurant($restaurantId)): ?>
                    <section class="manage-section" aria-labelledby="manage-heading">
                        <h2 id="manage-heading">Manage restaurant</h2>
                        <div class="page-actions">
                            <a class="secondary-button" href="restaurant-edit.php?restaurant=<?= $restaurantId ?>">Edit restaurant</a>
                            <a class="danger-button" href="restaurant-delete.php?restaurant=<?= $restaurantId ?>">Delete restaurant</a>
                        </div>
                    </section>
                <?php endif; ?>
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
