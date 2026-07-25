<?php
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TUV Veritas</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background: var(--bg-alt); display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-box { background: var(--white); padding: 48px 40px; border-radius: var(--r-lg); border: 1px solid var(--line); max-width: 400px; width: 100%; box-shadow: var(--shadow-md); }
        .login-box h1 { font-size: 24px; margin-bottom: 8px; }
        .login-box p { color: var(--ink-500); font-size: 14px; margin-bottom: 28px; }
        .field { margin-bottom: 18px; }
        .field label { font-weight: 600; font-size: 13px; color: var(--ink-700); display: block; margin-bottom: 4px; }
        .field input { width: 100%; padding: 12px 14px; border: 1.5px solid var(--line); border-radius: var(--r-sm); font-size: 14px; }
        .field input:focus { border-color: var(--brand-blue); outline: none; }
        .error { color: #B42318; background: #FEF3F2; padding: 10px 14px; border-radius: var(--r-sm); font-size: 14px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔐 Admin Login</h1>
        <p>Enter your credentials to manage certificates.</p>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <form method="POST">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-gold btn-block" style="justify-content:center;">Log In</button>
        </form>
        <p style="margin-top:20px;font-size:12px;color:var(--ink-500);">Default: admin / TUV@2026</p>
    </div>
</body>
</html>