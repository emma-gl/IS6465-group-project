<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main>
        <h1>Find your next favorite</h1>
        <p class="intro">Explore local spots and see what diners are saying.</p>

        <section class="restaurant-list" aria-label="Restaurants">
            <article class="restaurant-card">
                <h2>Olive &amp; Ember</h2>
                <p>A cozy neighborhood trattoria serving handmade pasta, wood-fired vegetables, and seasonal Italian favorites.</p>
                <div class="rating" aria-label="Rated 4.8 out of 5">★★★★★ 4.8 / 5</div>
                <a class="details-button" href="restaurant-details.php?restaurant=olive-ember">See more details</a>
            </article>

            <article class="restaurant-card">
                <h2>Juniper Street Tacos</h2>
                <p>A lively taqueria known for slow-braised fillings, bright salsas, and fresh tortillas made throughout the day.</p>
                <div class="rating" aria-label="Rated 4.6 out of 5">★★★★★ 4.6 / 5</div>
                <a class="details-button" href="restaurant-details.php?restaurant=juniper-street-tacos">See more details</a>
            </article>

            <article class="restaurant-card">
                <h2>Harborlight Kitchen</h2>
                <p>A relaxed seafood restaurant featuring daily catches, crisp fish sandwiches, and a sunny waterfront patio.</p>
                <div class="rating" aria-label="Rated 4.4 out of 5">★★★★☆ 4.4 / 5</div>
                <a class="details-button" href="restaurant-details.php?restaurant=harborlight-kitchen">See more details</a>
            </article>

            <article class="restaurant-card">
                <h2>Maple &amp; Main Brunch House</h2>
                <p>An all-day brunch favorite with fluffy pancakes, hearty breakfast bowls, and locally roasted coffee.</p>
                <div class="rating" aria-label="Rated 4.7 out of 5">★★★★★ 4.7 / 5</div>
                <a class="details-button" href="restaurant-details.php?restaurant=maple-main-brunch-house">See more details</a>
            </article>

            <article class="restaurant-card">
                <h2>Cedar Bowl Noodle Bar</h2>
                <p>A casual noodle shop dishing up rich broths, hand-pulled noodles, and customizable bowls with seasonal toppings.</p>
                <div class="rating" aria-label="Rated 4.5 out of 5">★★★★★ 4.5 / 5</div>
                <a class="details-button" href="restaurant-details.php?restaurant=cedar-bowl-noodle-bar">See more details</a>
            </article>
        </section>
    </main>
</body>
</html>