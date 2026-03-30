<?php
session_start();
require_once '../include/config.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php"); exit;
}

$error        = '';
$show2fa      = false;
$captchaError = false;

// ── Generate Math CAPTCHA ─────────────────────────────────────
function generateCaptcha() {
    $ops = ['+', '-', '*'];
    $op  = $ops[array_rand($ops)];
    switch ($op) {
        case '+': $a = rand(2, 15); $b = rand(2, 15); $ans = $a + $b; break;
        case '-': $a = rand(5, 20); $b = rand(1, $a);  $ans = $a - $b; break;
        case '*': $a = rand(2, 9);  $b = rand(2, 9);   $ans = $a * $b; break;
    }
    return ['a' => $a, 'b' => $b, 'op' => $op, 'answer' => $ans];
}

// Init captcha in session if not set
if (empty($_SESSION['captcha'])) {
    $_SESSION['captcha'] = generateCaptcha();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, email, password, role, status, two_fa_enabled FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if (!$admin['status']) {
                $error = "Your account has been deactivated. Contact a super admin.";
            } elseif (!password_verify($password, $admin['password'])) {
                $error = "Invalid email or password.";
                // Regenerate captcha on failed attempt
                $_SESSION['captcha'] = generateCaptcha();
            } elseif ($admin['two_fa_enabled']) {
                // ── 2FA Captcha Check ─────────────────────────────
                $captchaAnswer = trim($_POST['captcha_answer'] ?? '');
                if (empty($captchaAnswer)) {
                    $error    = "Please solve the security question.";
                    $show2fa  = true;
                    // Store email+password in session temporarily
                    $_SESSION['pending_admin_email'] = $email;
                } elseif ((int)$captchaAnswer !== (int)$_SESSION['captcha']['answer']) {
                    $error        = "Incorrect answer. Please try again.";
                    $captchaError = true;
                    $show2fa      = true;
                    $_SESSION['captcha'] = generateCaptcha(); // Regenerate
                    $_SESSION['pending_admin_email'] = $email;
                } else {
                    // ── Login Success (2FA passed) ─────────────────
                    unset($_SESSION['captcha'], $_SESSION['pending_admin_email']);
                    $_SESSION['admin_id']    = $admin['id'];
                    $_SESSION['admin_name']  = $admin['name'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_role']  = $admin['role'];

                    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
                    $conn->query("UPDATE admin_users SET last_login=NOW(), last_login_ip='$ip', login_count=login_count+1 WHERE id={$admin['id']}");
                    $conn->query("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES ({$admin['id']}, 'login', 'Login with 2FA captcha', '$ip', NOW())");

                    header("Location: index.php"); exit;
                }
            } else {
                // ── Login Success (no 2FA) ─────────────────────────
                $_SESSION['admin_id']    = $admin['id'];
                $_SESSION['admin_name']  = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role']  = $admin['role'];

                $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
                $conn->query("UPDATE admin_users SET last_login=NOW(), last_login_ip='$ip', login_count=login_count+1 WHERE id={$admin['id']}");
                $conn->query("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES ({$admin['id']}, 'login', 'Standard login', '$ip', NOW())");

                header("Location: index.php"); exit;
            }
        } else {
            $error = "Invalid email or password.";
            $_SESSION['captcha'] = generateCaptcha();
        }
        $stmt->close();
    }
}

// If credentials were correct but captcha pending, show 2FA step
if (!empty($_SESSION['pending_admin_email'])) {
    $show2fa = true;
}

$captcha = $_SESSION['captcha'];
// Symbols for display
$opDisplay = ['+'=> '+', '-' => '−', '*' => '×'];
$opSym = $opDisplay[$captcha['op']] ?? $captcha['op'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — R.K. Hospital</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Segoe UI', system-ui, sans-serif; }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f2d6b 0%, #1a6ef5 60%, #0dcaf0 100%);
            padding: 24px 16px;
            position: relative;
            overflow: hidden;
        }

        /* Background blobs */
        .auth-wrapper::before, .auth-wrapper::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.12;
            pointer-events: none;
        }
        .auth-wrapper::before {
            width: 500px; height: 500px;
            background: #fff;
            top: -120px; right: -100px;
        }
        .auth-wrapper::after {
            width: 350px; height: 350px;
            background: #fff;
            bottom: -80px; left: -60px;
        }

        .auth-box {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(0,0,0,0.22);
            display: flex;
            width: 860px;
            max-width: 100%;
            position: relative;
            z-index: 1;
        }

        /* ── Left Panel ─────────────────────────── */
        .auth-left {
            background: linear-gradient(160deg, #1a6ef5, #0a3fa0);
            padding: 52px 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-width: 280px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            top: -80px; right: -80px;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            bottom: -50px; left: -50px;
        }
        .auth-left img {
            max-width: 120px;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.25));
            position: relative; z-index: 1;
        }
        .auth-left .brand-name {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 800;
            text-align: center;
            margin-top: 16px;
            letter-spacing: 0.3px;
            position: relative; z-index: 1;
        }
        .auth-left .brand-sub {
            color: rgba(255,255,255,0.65);
            font-size: 0.78rem;
            text-align: center;
            margin-top: 4px;
            position: relative; z-index: 1;
        }
        .auth-left .divider {
            width: 40px; height: 3px;
            background: rgba(255,255,255,0.35);
            border-radius: 4px;
            margin: 20px auto;
            position: relative; z-index: 1;
        }
        .auth-left .security-badges {
            display: flex; flex-direction: column; gap: 10px;
            width: 100%;
            position: relative; z-index: 1;
        }
        .auth-left .badge-item {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 10px;
            padding: 10px 14px;
            display: flex; align-items: center; gap: 10px;
            color: rgba(255,255,255,0.9);
            font-size: 0.78rem;
            font-weight: 600;
        }
        .auth-left .badge-item i { font-size: 0.95rem; color: #7dd3fc; }

        /* ── Right Panel ────────────────────────── */
        .auth-right {
            padding: 44px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-right .step-indicator {
            display: flex; align-items: center; gap: 0; margin-bottom: 28px;
        }
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700;
            transition: all 0.3s;
        }
        .step-dot.active   { background: #1a6ef5; color: #fff; }
        .step-dot.done     { background: #198754; color: #fff; }
        .step-dot.inactive { background: #e9ecef; color: #adb5bd; }
        .step-line { flex: 1; height: 2px; background: #e9ecef; }
        .step-line.done { background: #198754; }
        .step-label { font-size: 0.65rem; text-align: center; color: #6c757d; margin-top: 4px; font-weight: 600; }

        .auth-heading { font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
        .auth-sub     { color: #94a3b8; font-size: 0.875rem; margin-bottom: 24px; }

        .form-label {
            font-size: 0.72rem; font-weight: 700;
            color: #64748b; text-transform: uppercase;
            letter-spacing: 0.5px; margin-bottom: 6px;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.65rem 1rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
            transition: border-color .2s, box-shadow .2s;
            color: #0f172a;
        }
        .form-control:focus {
            border-color: #1a6ef5;
            box-shadow: 0 0 0 3px rgba(26,110,245,0.12);
            outline: none;
        }
        .input-group .form-control { border-radius: 0 10px 10px 0 !important; }
        .input-group-text {
            background: #f8fafc; border: 1.5px solid #e2e8f0;
            border-right: none; border-radius: 10px 0 0 10px;
            color: #94a3b8; font-size: 0.9rem;
            transition: border-color .2s;
        }
        .form-control:focus ~ .input-group-text,
        .input-group:focus-within .input-group-text { border-color: #1a6ef5; }

        .btn-login {
            background: linear-gradient(135deg, #1a6ef5, #0a4fc4);
            border: none; border-radius: 10px;
            padding: 0.75rem; font-weight: 700; font-size: 0.95rem;
            color: #fff; width: 100%;
            box-shadow: 0 4px 14px rgba(26,110,245,0.35);
            transition: all 0.2s; cursor: pointer;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,110,245,0.4); }
        .btn-login:active { transform: none; }

        .forgot-link {
            font-size: 0.8rem; color: #1a6ef5;
            text-decoration: none; font-weight: 600;
        }
        .forgot-link:hover { text-decoration: underline; }

        /* ── Math Captcha ───────────────────────── */
        .captcha-card {
            background: linear-gradient(135deg, #f0f6ff, #e8f4fd);
            border: 2px solid #bfdbfe;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 20px;
            animation: fadeInDown 0.35s ease;
        }
        .captcha-card .captcha-label {
            font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #1a6ef5; margin-bottom: 12px;
            display: flex; align-items: center; gap: 6px;
        }
        .captcha-equation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 14px;
        }
        .captcha-num {
            width: 52px; height: 52px;
            background: #1a6ef5;
            color: #fff;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; font-weight: 800;
            box-shadow: 0 4px 12px rgba(26,110,245,0.3);
            user-select: none;
        }
        .captcha-op {
            width: 40px; height: 40px;
            background: #fff;
            border: 2px solid #bfdbfe;
            color: #1a6ef5;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; font-weight: 800;
            user-select: none;
        }
        .captcha-eq {
            color: #64748b;
            font-size: 1.3rem;
            font-weight: 700;
        }
        .captcha-input-wrap { position: relative; }
        .captcha-input {
            text-align: center;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: 4px;
            border-radius: 10px !important;
            border: 2px solid #bfdbfe !important;
            background: #fff;
            color: #0f172a;
            padding: 0.6rem 1rem !important;
        }
        .captcha-input:focus { border-color: #1a6ef5 !important; box-shadow: 0 0 0 3px rgba(26,110,245,0.12) !important; }
        .captcha-input.error { border-color: #dc3545 !important; animation: shake 0.4s ease; }
        .captcha-input.success { border-color: #198754 !important; }

        /* ── Alert ──────────────────────────────── */
        .auth-alert {
            border-radius: 10px;
            font-size: 0.85rem;
            padding: 12px 16px;
            border: none;
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 18px;
        }
        .auth-alert.danger  { background: #fff5f5; color: #c53030; border-left: 4px solid #fc8181; }
        .auth-alert.success { background: #f0fff4; color: #276749; border-left: 4px solid #68d391; }

        /* ── Animations ─────────────────────────── */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60%  { transform: translateX(-6px); }
            40%, 80%  { transform: translateX(6px); }
        }
        .form-section { animation: fadeInDown 0.3s ease; }

        /* ── Footer ─────────────────────────────── */
        .auth-footer {
            font-size: 0.8rem; color: #94a3b8;
            margin-top: 20px; text-align: center;
        }
        .auth-footer a { color: #1a6ef5; font-weight: 700; text-decoration: none; }

        /* ── Responsive ─────────────────────────── */
        @media (max-width: 640px) {
            .auth-left  { display: none; }
            .auth-right { padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-box">

        <!-- ── Left Panel ──────────────────────────────────── -->
        <div class="auth-left">
            <img src="../assets/img/RK-Logo.png" alt="R.K. Hospital">
            <div class="brand-name">R.K. Hospital</div>
            <div class="brand-sub">Admin Control Panel</div>
            <div class="divider"></div>
            <div class="security-badges">
                <div class="badge-item">
                    <i class="fa fa-lock"></i>
                    <span>256-bit Encrypted</span>
                </div>
                <div class="badge-item">
                    <i class="fa fa-shield-alt"></i>
                    <span>2FA Protection</span>
                </div>
                <div class="badge-item">
                    <i class="fa fa-user-check"></i>
                    <span>Role-Based Access</span>
                </div>
                <div class="badge-item">
                    <i class="fa fa-history"></i>
                    <span>Activity Logged</span>
                </div>
            </div>
        </div>

        <!-- ── Right Panel ─────────────────────────────────── -->
        <div class="auth-right">

            <!-- Step Indicator -->
            <div class="mb-4">
                <div class="step-indicator">
                    <div class="step-dot <?= $show2fa ? 'done' : 'active' ?>">
                        <?= $show2fa ? '<i class="fa fa-check" style="font-size:.65rem;"></i>' : '1' ?>
                    </div>
                    <div class="step-line <?= $show2fa ? 'done' : '' ?>"></div>
                    <div class="step-dot <?= $show2fa ? 'active' : 'inactive' ?>">2</div>
                </div>
                <div class="d-flex justify-content-between px-1" style="margin-top:4px;">
                    <div class="step-label" style="color:<?= !$show2fa ? '#1a6ef5' : '#198754' ?>;">Credentials</div>
                    <div class="step-label" style="color:<?= $show2fa ? '#1a6ef5' : '#adb5bd' ?>;">Verification</div>
                </div>
            </div>

            <?php if (!$show2fa): ?>
            <!-- ══ STEP 1: Email + Password ══════════════════════ -->
            <div class="form-section">
                <h2 class="auth-heading">Welcome Back</h2>
                <p class="auth-sub">Sign in to your admin account</p>

                <?php if (!empty($error)): ?>
                <div class="auth-alert danger">
                    <i class="fa fa-circle-xmark mt-1"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
                <?php endif; ?>

                <form method="POST" action="login.php" id="loginForm">
                    <input type="hidden" name="form_step" value="credentials">

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control"
                                   placeholder="admin@rkhospital.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" id="passwordField"
                                   class="form-control"
                                   placeholder="Enter your password"
                                   autocomplete="current-password" required>
                            <button type="button" class="input-group-text bg-light border-start-0"
                                    style="border-radius:0 10px 10px 0;border:1.5px solid #e2e8f0;cursor:pointer;"
                                    onclick="togglePw()" id="pwToggle">
                                <i class="fa fa-eye text-muted" id="pwEye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-end mb-4">
                        <a href="forgot-password.php" class="forgot-link">
                            <i class="fa fa-key me-1"></i>Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fa fa-right-to-bracket me-2"></i>Continue
                    </button>
                </form>
            </div>

            <?php else: ?>
            <!-- ══ STEP 2: Math CAPTCHA (2FA users only) ═════════ -->
            <div class="form-section">
                <h2 class="auth-heading">Security Check</h2>
                <p class="auth-sub">Solve the equation to verify it's you</p>

                <?php if (!empty($error)): ?>
                <div class="auth-alert danger">
                    <i class="fa fa-circle-xmark mt-1"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
                <?php endif; ?>

                <form method="POST" action="login.php" id="captchaForm">
                    <input type="hidden" name="email"    value="<?= htmlspecialchars($_SESSION['pending_admin_email'] ?? '') ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>">
                    <input type="hidden" name="form_step" value="captcha">

                    <!-- Math CAPTCHA Card -->
                    <div class="captcha-card">
                        <div class="captcha-label">
                            <i class="fa fa-calculator"></i>
                            Solve to verify your identity
                        </div>

                        <div class="captcha-equation">
                            <div class="captcha-num"><?= $captcha['a'] ?></div>
                            <div class="captcha-op"><?= $opSym ?></div>
                            <div class="captcha-num"><?= $captcha['b'] ?></div>
                            <div class="captcha-eq">=</div>
                            <div style="flex:1;">
                                <input type="number"
                                       name="captcha_answer"
                                       id="captchaInput"
                                       class="form-control captcha-input <?= $captchaError ? 'error' : '' ?>"
                                       placeholder="?"
                                       autocomplete="off"
                                       autofocus
                                       required>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="small text-muted" id="captchaHint" style="font-size:.75rem;">
                                <i class="fa fa-info-circle me-1 text-primary"></i>
                                Enter the result of: <strong><?= $captcha['a'] ?> <?= $opSym ?> <?= $captcha['b'] ?></strong>
                            </div>
                            <a href="login.php?refresh_captcha=1" class="text-primary text-decoration-none"
                               style="font-size:.75rem;font-weight:700;">
                                <i class="fa fa-refresh me-1"></i>New question
                            </a>
                        </div>
                    </div>

                    <!-- Live feedback -->
                    <div id="captchaLive" class="mb-3" style="min-height:24px;"></div>

                    <button type="submit" class="btn-login" id="captchaBtn">
                        <i class="fa fa-shield-alt me-2"></i>Verify &amp; Login
                    </button>

                    <div class="text-center mt-3">
                        <a href="login.php" class="text-muted text-decoration-none" style="font-size:.8rem;font-weight:600;">
                            <i class="fa fa-arrow-left me-1"></i>Back to login
                        </a>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <div class="auth-footer">
                &copy; <?= date('Y') ?> R.K. Hospital. All rights reserved.
            </div>

        </div><!-- /auth-right -->
    </div><!-- /auth-box -->
</div><!-- /auth-wrapper -->

<?php
// Refresh captcha via GET
if (isset($_GET['refresh_captcha'])) {
    $_SESSION['captcha'] = generateCaptcha();
    header("Location: login.php"); exit;
}
?>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
// ── Password Visibility ───────────────────────────────────────
function togglePw() {
    const f = document.getElementById('passwordField');
    const e = document.getElementById('pwEye');
    if (!f) return;
    const show = f.type === 'password';
    f.type = show ? 'text' : 'password';
    e.className = show ? 'fa fa-eye-slash text-muted' : 'fa fa-eye text-muted';
}

// ── Login Button Loading ──────────────────────────────────────
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...';
        btn.disabled  = true;
    });
}

// ── Captcha Live Feedback ─────────────────────────────────────
const captchaInput = document.getElementById('captchaInput');
if (captchaInput) {
    const correctAnswer = <?= (int)$captcha['answer'] ?>;

    captchaInput.addEventListener('input', function () {
        const val  = parseInt(this.value);
        const live = document.getElementById('captchaLive');
        const btn  = document.getElementById('captchaBtn');

        this.classList.remove('error', 'success');

        if (this.value === '') {
            live.innerHTML = '';
            btn.disabled   = false;
            return;
        }

        if (val === correctAnswer) {
            this.classList.add('success');
            live.innerHTML = `<div class="d-flex align-items-center gap-2 text-success small fw-bold">
                <i class="fa fa-check-circle fs-5"></i>
                <span>Correct! Click verify to log in.</span>
            </div>`;
            btn.disabled = false;
            // Auto-submit after short delay
            setTimeout(() => {
                document.getElementById('captchaForm').submit();
            }, 700);
        } else if (this.value.length >= String(correctAnswer).length + 1) {
            this.classList.add('error');
            live.innerHTML = `<div class="d-flex align-items-center gap-2 text-danger small fw-bold">
                <i class="fa fa-times-circle fs-5"></i>
                <span>That doesn't look right. Try again.</span>
            </div>`;
        } else {
            live.innerHTML = `<div class="d-flex align-items-center gap-2 text-muted small">
                <i class="fa fa-pencil-alt"></i>
                <span>Keep going...</span>
            </div>`;
        }
    });

    // ── Block non-numeric input (allow backspace, arrows) ─────
    captchaInput.addEventListener('keypress', function (e) {
        if (!/[0-9\-]/.test(e.key)) e.preventDefault();
    });

    // ── Captcha submit loading ────────────────────────────────
    document.getElementById('captchaForm').addEventListener('submit', function () {
        const btn = document.getElementById('captchaBtn');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Checking...';
        btn.disabled  = true;
    });
}
</script>
</body>
</html>