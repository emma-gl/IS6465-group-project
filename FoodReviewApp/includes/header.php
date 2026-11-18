<?php $headerUser = currentUser(); ?>
<header>
    <a href="landing-page.php" aria-label="FoodReview home">FoodReview</a>
    <nav class="header-links" aria-label="Account">
        <?php if ($headerUser === null): ?>
            <a class="account-button" href="login.php">Log in</a>
        <?php else: ?>
            <a class="account-button" href="account-info.php">Account Info</a>
            <a href="logout.php">Log out</a>
        <?php endif; ?>
    </nav>
</header>
