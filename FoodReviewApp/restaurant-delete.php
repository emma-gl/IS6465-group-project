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
    <title>Delete Restaurant | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <section class="restaurant-details">
            <?php if ($restaurant === null): ?>
                <h1>Restaurant not found</h1>
                <p class="intro">Choose a restaurant from the list first.</p>
                <a class="details-button" href="restaurant-list.php">Back to restaurants</a>
            <?php else: ?>
                <?php $detailsUrl = 'restaurant-details.php?restaurant=' . urlencode($restaurantId); ?>
                <h1>Delete Restaurant</h1>
                <p class="intro">
                    Are you sure you want to delete <strong><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></strong>?
                    Its reviews will be removed too.
                </p>
                <form class="page-actions" method="post" action="">
                    <input type="hidden" name="restaurant" value="<?= htmlspecialchars($restaurantId, ENT_QUOTES, 'UTF-8') ?>">
                    <button class="danger-button" type="button">Delete</button>
                    <a class="secondary-button" href="<?= htmlspecialchars($detailsUrl, ENT_QUOTES, 'UTF-8') ?>">Cancel</a>
                </form>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
