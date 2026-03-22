<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'dbcon.php';
?>

<!-- profile page UI -->
<main id="main">
    <div class="p-5 mb-4 bg-white rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>
            <hr class="my-4">
            <p>Your User ID is: <?php echo $_SESSION['user_id']; ?></p>

            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>

        </div>
    </div>
</main>
</body>
</html>
