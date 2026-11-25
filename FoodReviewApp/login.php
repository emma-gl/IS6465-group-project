<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: landing-page.php');
    exit;
}

$login = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedLogin = $_POST['login'] ?? '';
    $submittedPassword = $_POST['password'] ?? '';

    $login = is_string($submittedLogin) ? trim($submittedLogin) : '';
    $password = is_string($submittedPassword) ? $submittedPassword : '';

    if ($login === '' || $password === '') {
        $error = 'Please enter your username or email and your password.';
    } elseif (attemptLogin($login, $password)) {
        header('Location: landing-page.php');
        exit;
    } else {
        $error = 'Incorrect username/email or password.';
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
            <label for="login">Username or email</label>
            <input
                type="text"
                id="login"
                name="login"
                value="<?= htmlspecialchars($login, ENT_QUOTES, 'UTF-8') ?>"
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

        <p class="form-switch">New to FoodReview? <a href="register.php">Create an account</a></p>
    </main>
</body>
</html>
