<?php
session_start();
require_once '../include/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address!";
    } else {
        // Fetch admin by email
        $stmt = $conn->prepare("SELECT id, name, email, password FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                // Set session
                $_SESSION['admin_id']    = $admin['id'];
                $_SESSION['admin_name']  = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];

                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - R.K. Hospital</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a6ef5 0%, #0a4fc4 100%);
            padding: 20px;
        }
        .auth-box {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            display: flex;
            width: 820px;
            max-width: 100%;
        }
        .auth-left {
            background: linear-gradient(135deg, #1a6ef5, #0a4fc4);
            padding: 50px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-width: 260px;
        }
        .auth-left img { max-width: 150px; }
        .auth-left h3 { color: #fff; margin-top: 20px; font-size: 16px; text-align: center; opacity: 0.85; }
        .auth-right { padding: 40px 35px; flex: 1; }
        .auth-right h1 { font-size: 26px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
        .auth-right .subtitle { color: #888; margin-bottom: 25px; font-size: 14px; }
        .form-label { font-size: 13px; font-weight: 600; color: #444; margin-bottom: 5px; }
        .form-control { border-radius: 8px; padding: 11px 15px; border: 1.5px solid #e0e0e0; font-size: 14px; }
        .form-control:focus { border-color: #1a6ef5; box-shadow: 0 0 0 3px rgba(26,110,245,0.1); }
        .btn-primary { background: #1a6ef5; border: none; border-radius: 8px; padding: 12px; font-weight: 600; font-size: 15px; }
        .btn-primary:hover { background: #0a4fc4; }
        .forgot-link { font-size: 13px; color: #1a6ef5; text-decoration: none; }
        .auth-footer { font-size: 14px; color: #666; margin-top: 18px; text-align: center; }
        .auth-footer a { color: #1a6ef5; font-weight: 600; text-decoration: none; }
        .alert { border-radius: 8px; font-size: 14px; padding: 10px 14px; }
        @media (max-width: 600px) { .auth-left { display: none; } .auth-right { padding: 30px 20px; } }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-box">

        <div class="auth-left">
            <img src="../assets/img/RK-Logo.png" alt="RK Hospital">
            <h3>Admin Panel<br>R.K. Hospital</h3>
        </div>

        <div class="auth-right">
            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to your admin account</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Enter your email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Enter your password" required>
                </div>
                <div class="text-end mb-4">
                    <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                </button>
            </form>

            <div class="auth-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>

    </div>
</div>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>