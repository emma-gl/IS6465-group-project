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

function attemptLogin(string $email, string $password): bool
{
    $statement = db()->prepare('SELECT user_id, first_name, password_hash, role FROM users WHERE email = ?');
    $statement->execute([$email]);
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

// TODO: add owners to restaurants. currently, every owner will own the first 2 restaurants
function getOwnedRestaurantIds(): array
{
    return hasRole('Restaurant') ? [1, 2] : [];
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
