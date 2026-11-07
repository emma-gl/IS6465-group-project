<?php
session_start();

$username = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedUsername = $_POST['username'] ?? '';
    $submittedPassword = $_POST['password'] ?? '';

    $username = is_string($submittedUsername) ? trim($submittedUsername) : '';
    $password = is_string($submittedPassword) ? trim($submittedPassword) : '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both your username and password.';
    } else {
        // TEMPORARY: remember which login button was pressed so Account Info opens the right page.
        $_SESSION['role'] = ($_POST['role'] ?? '') === 'restaurant_owner' ? 'restaurant_owner' : 'reviewer';
        header('Location: landing-page.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page">
    <main>
        <h1>Welcome back</h1>
        <p>Log in to your FoodReview account.</p>

        <?php if ($error !== ''): ?>
            <p class="error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <div class="login-buttons">
                <button type="submit" name="role" value="reviewer">Log in as Reviewer</button>
                <button type="submit" name="role" value="restaurant_owner">Log in as Restaurant Owner</button>
            </div>
        </form>
    </main>
</body>
</html>
