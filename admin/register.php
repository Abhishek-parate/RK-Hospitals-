<?php
session_start();
require_once '../include/config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } elseif ($password !== $confirm) {
        $error = "Password and Confirm Password do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This email is already registered!";
        } else {
            // Hash password and insert new admin
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $ins = $conn->prepare("INSERT INTO admin_users (name, email, password) VALUES (?, ?, ?)");
            $ins->bind_param("sss", $name, $email, $hashed);

            if ($ins->execute()) {
                $success = "Account created successfully! Please login.";
            } else {
                $error = "Something went wrong. Please try again!";
            }
            $ins->close();
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
    <title>Admin Register - R.K. Hospital</title>
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
            <h1>Create Account</h1>
            <p class="subtitle">Register as Administrator</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="Enter your full name"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Enter your email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Minimum 6 characters" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm" class="form-control"
                           placeholder="Re-enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-user-plus me-2"></i>Register
                </button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>

    </div>
</div>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>