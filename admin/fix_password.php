<?php
require_once '../include/config.php';

// ── Change these two values ───────────────────────────────────
$adminEmail   = 'admin@gmail.com'; // your actual email
$newPassword  = 'Abhi@9860!';          // your desired password
// ─────────────────────────────────────────────────────────────

$hashed = password_hash($newPassword, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed, $adminEmail);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "✅ Password updated successfully!<br>";
    echo "Hash: <code>" . $hashed . "</code><br><br>";
    echo "<strong style='color:red;'>DELETE this file now!</strong>";
} else {
    echo "❌ No rows updated. Check the email address.";
    // Show what emails exist
    $res = $conn->query("SELECT id, email, LEFT(password,10) as pw_start FROM admin_users");
    echo "<pre>"; while($r=$res->fetch_assoc()) print_r($r); echo "</pre>";
}
$stmt->close();