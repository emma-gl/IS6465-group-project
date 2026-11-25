<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: landing-page.php');
    exit;
}

$fields = ['username', 'first_name', 'last_name', 'email', 'password', 'confirm_password', 'role'];
$form = array_fill_keys($fields, '');
$form['role'] = 'Member';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($fields as $field) {
        $value = $_POST[$field] ?? '';
        $value = is_string($value) ? $value : '';
        // Passwords are kept exactly as typed; everything else is trimmed.
        $form[$field] = str_contains($field, 'password') ? $value : trim($value);
    }

    $errors = registerUser($form);
    if ($errors === []) {
        header('Location: landing-page.php');
        exit;
    }
}

function old(array $form, string $field): string
{
    return htmlspecialchars($form[$field], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page">
    <main>
        <h1>Create an account</h1>
        <p>Join FoodReview to review dishes or manage your restaurant.</p>

        <?php if ($errors !== []): ?>
            <ul class="error" role="alert">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= old($form, 'username') ?>"
                   autocomplete="username" minlength="3" maxlength="50" pattern="[A-Za-z0-9_.]+" required>

            <div class="form-row">
                <div>
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" value="<?= old($form, 'first_name') ?>"
                           autocomplete="given-name" maxlength="100" required>
                </div>
                <div>
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" value="<?= old($form, 'last_name') ?>"
                           autocomplete="family-name" maxlength="100" required>
                </div>
            </div>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= old($form, 'email') ?>"
                   autocomplete="email" maxlength="255" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   autocomplete="new-password" minlength="8" required>

            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password"
                   autocomplete="new-password" minlength="8" required>

            <label for="role">Account type</label>
            <select id="role" name="role" required>
                <?php foreach (REGISTRATION_ROLES as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $form['role'] === $value ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Sign up</button>
        </form>

        <p class="form-switch">Already have an account? <a href="login.php">Log in</a></p>
    </main>
</body>
</html>
