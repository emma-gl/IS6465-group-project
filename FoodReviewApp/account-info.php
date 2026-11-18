<?php
require_once 'includes/auth.php';

requireLogin();

// Restaurant owners get their own account page.
if (hasRole('Restaurant')) {
    header('Location: owner-account-info.php');
    exit;
}

require_once 'includes/restaurants.php';
require_once 'includes/reviews.php';

$currentUserId = currentUser()['id'];
$userReviews = getReviewsByUser($currentUserId);
$followedRestaurants = getFollowedRestaurants($currentUserId);
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

    <main class="wide">
        <h1>Account Info</h1>
        <p class="intro">A snapshot of your reviews and the restaurants you follow.</p>

        <div class="account-grid">
            <section class="account-section" aria-labelledby="reviews-heading">
                <h2 id="reviews-heading">Your Reviews</h2>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Your Rating</th>
                                <th scope="col">Date Rated</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userReviews as $review): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($review['restaurant_name'], ENT_QUOTES, 'UTF-8') ?>
                                        <span class="cell-note"><?= htmlspecialchars($review['food_item'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </td>
                                    <td class="rating" aria-label="Rated <?= (int) $review['rating'] ?> out of 5"><?= ratingStars($review['rating']) ?></td>
                                    <td><?= formatReviewDate($review['created_at']) ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="secondary-button button-small" href="review-edit.php?id=<?= (int) $review['id'] ?>">Edit</a>
                                            <button class="danger-button button-small" type="button">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="account-section" aria-labelledby="followed-heading">
                <h2 id="followed-heading">Followed Restaurants</h2>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($followedRestaurants as $restaurant): ?>
                                <tr>
                                    <td><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="secondary-button button-small" href="restaurant-details.php?restaurant=<?= (int) $restaurant['id'] ?>">Info</a>
                                            <button class="danger-button button-small" type="button">Unfollow</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="center-action">
            <a class="details-button" href="restaurant-list.php">Add new review</a>
        </div>
    </main>
</body>
</html>
