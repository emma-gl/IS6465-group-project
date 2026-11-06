<?php
$restaurants = [
    'olive-ember' => [
        'name' => 'Olive & Ember',
        'description' => 'A cozy neighborhood trattoria serving handmade pasta, wood-fired vegetables, and seasonal Italian favorites.',
        'rating' => '4.8',
        'stars' => '★★★★★',
    ],
    'juniper-street-tacos' => [
        'name' => 'Juniper Street Tacos',
        'description' => 'A lively taqueria known for slow-braised fillings, bright salsas, and fresh tortillas made throughout the day.',
        'rating' => '4.6',
        'stars' => '★★★★★',
    ],
    'harborlight-kitchen' => [
        'name' => 'Harborlight Kitchen',
        'description' => 'A relaxed seafood restaurant featuring daily catches, crisp fish sandwiches, and a sunny waterfront patio.',
        'rating' => '4.4',
        'stars' => '★★★★☆',
    ],
    'maple-main-brunch-house' => [
        'name' => 'Maple & Main Brunch House',
        'description' => 'An all-day brunch favorite with fluffy pancakes, hearty breakfast bowls, and locally roasted coffee.',
        'rating' => '4.7',
        'stars' => '★★★★★',
    ],
    'cedar-bowl-noodle-bar' => [
        'name' => 'Cedar Bowl Noodle Bar',
        'description' => 'A casual noodle shop dishing up rich broths, hand-pulled noodles, and customizable bowls with seasonal toppings.',
        'rating' => '4.5',
        'stars' => '★★★★★',
    ],
];

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
                <a class="details-button" href="landing-page.php">Back to restaurants</a>
            </section>
        <?php else: ?>
            <article class="restaurant-details">
                <a class="back-link" href="landing-page.php">← Back to restaurants</a>
                <h1><?= htmlspecialchars($restaurant['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="restaurant-description"><?= htmlspecialchars($restaurant['description'], ENT_QUOTES, 'UTF-8') ?></p>
                <div class="rating" aria-label="Rated <?= htmlspecialchars($restaurant['rating'], ENT_QUOTES, 'UTF-8') ?> out of 5">
                    <?= $restaurant['stars'] ?> <?= htmlspecialchars($restaurant['rating'], ENT_QUOTES, 'UTF-8') ?> / 5
                </div>
                <button class="follow-button" type="button" aria-pressed="false">Follow</button>
                <button class="follow-button review-toggle" type="button" aria-expanded="false" aria-controls="review-form">
                    Write a review
                </button>
                <form class="review-form" id="review-form" hidden>
                    <label for="review-text">Your review</label>
                    <textarea id="review-text" name="review" rows="5"></textarea>

                    <fieldset class="star-rating">
                        <legend>Your rating</legend>
                        <?php for ($stars = 1; $stars <= 5; $stars++): ?>
                            <label>
                                <input type="radio" name="rating" value="<?= $stars ?>">
                                <?= $stars ?> star<?= $stars === 1 ? '' : 's' ?>
                            </label>
                        <?php endfor; ?>
                    </fieldset>

                    <button class="follow-button" type="button" disabled>This feature is not yet available</button>
                </form>
            </article>
        <?php endif; ?>
    </main>
    <script>
        const followButton = document.querySelector('.follow-button');

        if (followButton) {
            followButton.addEventListener('click', () => {
                const isFollowing = followButton.getAttribute('aria-pressed') === 'true';
                followButton.setAttribute('aria-pressed', String(!isFollowing));
                followButton.textContent = isFollowing ? 'Follow' : 'Following';
            });
        }

        const reviewToggle = document.querySelector('.review-toggle');
        const reviewForm = document.querySelector('.review-form');

        if (reviewToggle && reviewForm) {
            reviewToggle.addEventListener('click', () => {
                const isExpanded = reviewToggle.getAttribute('aria-expanded') === 'true';
                reviewToggle.setAttribute('aria-expanded', String(!isExpanded));
                reviewForm.hidden = isExpanded;
                reviewToggle.textContent = isExpanded ? 'Write a review' : 'Close review form';
            });
        }
    </script>
</body>
</html>