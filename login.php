<?php
// Start the session first
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php

$error_message = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required.";
    } else {
        try {
            // Find the user in the database by email
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);

            // Fetch the user
            $user = $stmt->fetch(); // Returns user array or false if not found

            // Check if user exists
            if (!$user) {
                $error_message = "No user found with email: " . htmlspecialchars($email);
            } else {
                // Verify the user and password
                // password_verify() securely compares the typed password
                // with the hash stored in the database.
                if (password_verify($password, $user['password'])) {

                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];

                    // Redirect to the protected profile page
                    header("Location: profile.php");
                    exit; // Always exit after redirect
                } else {
                    // More specific password error
                    $error_message = "Password is incorrect for user: " . htmlspecialchars($email);
                }
            }

        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}

?>

<!-- Login page content -->
<main id="main" class="signup-page">
    <div class="container">
        <div class="main-card">
            <h2 class="content-title text-center">Login</h2>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
                <div class="alert alert-success">Sign up successful! Please login.</div>
            <?php endif; ?>

            <form action="login.php" method="POST" autocomplete="off">
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" autocomplete="off" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-cyan-6">Login</button>
                </div>
            </form>

            <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>
</main>
</body>
</html>