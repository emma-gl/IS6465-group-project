<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: landing-page.php');
    exit;
}

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedEmail = $_POST['email'] ?? '';
    $submittedPassword = $_POST['password'] ?? '';

    $email = is_string($submittedEmail) ? trim($submittedEmail) : '';
    $password = is_string($submittedPassword) ? $submittedPassword : '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both your email and password.';
    } elseif (attemptLogin($email, $password)) {
        header('Location: landing-page.php');
        exit;
    } else {
        $error = 'Incorrect email or password.';
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
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
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

            <button type="submit">Log in</button>
        </form>
    </main>
</body>
</html>
