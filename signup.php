<?php
require_once 'dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$error_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
 
    if (empty ($email) || empty ($password)) {
        $error_msg = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Please enter a valid email address.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error_msg = "Email is already registered. Please use a different email.";
            }
            else {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    
                if ($stmt->execute ([$email, $hash_password])) {
                    header ("Location: login.php?signup=success");
                    exit;
                } else {
                    $error_msg = "An error occured during registration. Please try again.";
                }
            }
        }
        catch (PDOException $e) {
            $error_msg = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!-- signup page content -->
<main id="main" class="signup-page">
    <div class="container">
        <div class="main-card">
            <h2 class="content-title text-center">Register</h2>
            <p class="text-muted">Create your account to book tickets and manage reservations.</p>

            <?php if (!empty ($error_msg)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
            <?php endif; ?>

            <form action="signup.php" method="POST">
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>" autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-cyan-6">Register</button>
                </div>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Log in now</a></p>
        </div>
    </div>
</main>
</body>
</html>