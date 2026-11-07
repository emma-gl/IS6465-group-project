<?php
require_once 'includes/restaurants.php';

// dummy data for the logged-in restaurant owner until real accounts exist
$ownedRestaurantIds = ['olive-ember', 'juniper-street-tacos'];
$managedRestaurants = array_intersect_key($restaurants, array_flip($ownedRestaurantIds));
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
        <p class="intro">
            The restaurants you manage.
        </p>

        <section class="account-section" aria-labelledby="restaurants-heading">
            <h2 id="restaurants-heading">Your Restaurants</h2>
            <?php if (count($managedRestaurants) === 0): ?>
                <p class="intro">You don't have any restaurants yet. Add one to get started.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Avg Rating</th>
                                <th scope="col">Followers</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($managedRestaurants as $restaurantId => $restaurant): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?>
                                        <span class="cell-note"><?= htmlspecialchars($restaurant['cuisine'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($restaurant['price_range'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </td>
                                    <td class="rating" aria-label="Rated <?= $restaurant['rating'] ?> out of 5"><?= ratingStars($restaurant['rating']) ?> <?= $restaurant['rating'] ?></td>
                                    <td><?= number_format($restaurant['followers']) ?></td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="secondary-button button-small" href="restaurant-details.php?restaurant=<?= urlencode($restaurantId) ?>">Info</a>
                                            <a class="secondary-button button-small" href="restaurant-edit.php?restaurant=<?= urlencode($restaurantId) ?>">Edit</a>
                                            <a class="danger-button button-small" href="restaurant-delete.php?restaurant=<?= urlencode($restaurantId) ?>">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <div class="center-action">
            <a class="details-button" href="restaurant-add.php">Add new restaurant</a>
        </div>
    </main>
</body>
</html>
