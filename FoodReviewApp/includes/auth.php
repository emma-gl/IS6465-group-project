<?php
// Login state and role checks. Require this at the very top of every page,
// before any HTML is sent, because it starts the session.
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

function hasRole(string ...$roles): bool
{
    $user = currentUser();
    return $user !== null && in_array($user['role'], $roles, true);
}

function attemptLogin(string $login, string $password): bool
{
    $statement = db()->prepare(
        'SELECT user_id, first_name, password_hash, role FROM users
         WHERE username = :login COLLATE NOCASE OR email = :login COLLATE NOCASE'
    );
    $statement->execute([':login' => $login]);
    $row = $statement->fetch();

    if ($row === false || !password_verify($password, $row['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $row['user_id'],
        'first_name' => $row['first_name'],
        'role' => $row['role'],
    ];
    return true;
}

// Roles a visitor may choose when signing up. Admins are created by hand.
const REGISTRATION_ROLES = [
    'Member' => 'Member (write reviews)',
    'Restaurant' => 'Restaurant owner',
];

// Creates a new account and logs the user in. Returns a list of error
// messages; an empty list means the account was created.
function registerUser(array $data): array
{
    $username = $data['username'];
    $firstName = $data['first_name'];
    $lastName = $data['last_name'];
    $email = $data['email'];
    $password = $data['password'];
    $role = $data['role'];

    $errors = [];

    if (!preg_match('/^[A-Za-z0-9_.]{3,50}$/', $username)) {
        $errors[] = 'Username must be 3–50 characters: letters, numbers, dots or underscores.';
    }
    if ($firstName === '' || mb_strlen($firstName) > 100) {
        $errors[] = 'Please enter your first name (up to 100 characters).';
    }
    if ($lastName === '' || mb_strlen($lastName) > 100) {
        $errors[] = 'Please enter your last name (up to 100 characters).';
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || strlen($email) > 255) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    } elseif ($password !== $data['confirm_password']) {
        $errors[] = 'Passwords do not match.';
    }
    if (!array_key_exists($role, REGISTRATION_ROLES)) {
        $errors[] = 'Please choose an account type.';
    }

    if ($errors !== []) {
        return $errors;
    }

    $taken = db()->prepare(
        'SELECT
            SUM(username = :username COLLATE NOCASE) AS username_taken,
            SUM(email = :email COLLATE NOCASE) AS email_taken
         FROM users'
    );
    $taken->execute([':username' => $username, ':email' => $email]);
    $row = $taken->fetch();
    if ((int) $row['username_taken'] > 0) {
        $errors[] = 'That username is already taken.';
    }
    if ((int) $row['email_taken'] > 0) {
        $errors[] = 'An account with that email already exists.';
    }
    if ($errors !== []) {
        return $errors;
    }

    $insert = db()->prepare(
        'INSERT INTO users (username, first_name, last_name, email, password_hash, role)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $insert->execute([
        $username,
        $firstName,
        $lastName,
        $email,
        password_hash($password, PASSWORD_DEFAULT),
        $role,
    ]);

    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) db()->lastInsertId(),
        'first_name' => $firstName,
        'role' => $role,
    ];
    return [];
}

function logout(): void
{
    $_SESSION = [];
    session_destroy();
}


function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireRole(string ...$roles): void
{
    requireLogin();
    if (!hasRole(...$roles)) {
        denyAccess();
    }
}

function denyAccess(): void
{
    http_response_code(403);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access denied | FoodReview</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    <main>
        <section class="restaurant-details">
            <h1>Access denied</h1>
            <p class="intro">Your account doesn't have permission to view this page.</p>
            <a class="details-button" href="landing-page.php">Back to home</a>
        </section>
    </main>
</body>
</html>
    <?php
    exit;
}

// IDs of the restaurants owned by the logged-in restaurant owner.
function getOwnedRestaurantIds(): array
{
    if (!hasRole('Restaurant')) {
        return [];
    }

    $statement = db()->prepare('SELECT restaurant_id FROM restaurants WHERE owner_user_id = ? ORDER BY restaurant_id');
    $statement->execute([currentUser()['id']]);
    return array_map('intval', $statement->fetchAll(PDO::FETCH_COLUMN));
}

function canAddRestaurant(): bool
{
    return hasRole('Restaurant', 'Admin');
}

function canManageRestaurant(int $restaurantId): bool
{
    return hasRole('Admin') || in_array($restaurantId, getOwnedRestaurantIds(), true);
}


function canEditReview(array $review): bool
{
    $user = currentUser();
    return $user !== null && ($user['role'] === 'Admin' || (int) $review['user_id'] === $user['id']);
}
