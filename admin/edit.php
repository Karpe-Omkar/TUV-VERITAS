<?php
require_once 'config.php';
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

$db = getDB();
$id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM certificates WHERE id = ?");
$stmt->execute([$id]);
$cert = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$cert) {
    die('Certificate not found.');
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cert_number = trim($_POST['cert_number']);
    $company_name = trim($_POST['company_name']);
    $standard = trim($_POST['standard']);
    $scope = trim($_POST['scope']);
    $issue_date = $_POST['issue_date'];
    $expiry_date = $_POST['expiry_date'];
    $status = $_POST['status'];

    try {
        $stmt = $db->prepare("UPDATE certificates SET cert_number=?, company_name=?, standard=?, scope=?, issue_date=?, expiry_date=?, status=? WHERE id=?");
        $stmt->execute([$cert_number, $company_name, $standard, $scope, $issue_date, $expiry_date, $status, $id]);
        $message = '<div style="background:#E6F7ED;color:#0D7A4A;padding:12px 18px;border-radius:var(--r-sm);margin-bottom:20px;">Certificate updated successfully!</div>';
        // Refresh data
        $stmt = $db->prepare("SELECT * FROM certificates WHERE id = ?");
        $stmt->execute([$id]);
        $cert = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = '<div style="background:#FEF3F2;color:#B42318;padding:12px 18px;border-radius:var(--r-sm);margin-bottom:20px;">Error: ' . $e->getMessage() . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-wrap { max-width: 700px; margin: 40px auto; background: var(--white); padding: 40px; border-radius: var(--r-lg); border: 1px solid var(--line); }
        .form-wrap h1 { font-size: 26px; margin-bottom: 6px; }
        .form-wrap .sub { color: var(--ink-500); margin-bottom: 28px; }
        .field textarea { min-height: 80px; resize: vertical; }
        .btn-back { margin-top: 20px; display: inline-block; color: var(--ink-500); }
    </style>
</head>
<body>
<div class="container">
    <div class="form-wrap">
        <h1>✏️ Edit Certificate</h1>
        <p class="sub">Update the certificate details below.</p>
        <?php echo $message; ?>
        <form method="POST">
            <div class="field">
                <label>Certificate Number <span class="req">*</span></label>
                <input type="text" name="cert_number" required value="<?php echo htmlspecialchars($cert['cert_number']); ?>">
            </div>
            <div class="field">
                <label>Company Name <span class="req">*</span></label>
                <input type="text" name="company_name" required value="<?php echo htmlspecialchars($cert['company_name']); ?>">
            </div>
            <div class="field">
                <label>Standard <span class="req">*</span></label>
                <input type="text" name="standard" required value="<?php echo htmlspecialchars($cert['standard']); ?>">
            </div>
            <div class="field">
                <label>Scope <span class="req">*</span></label>
                <textarea name="scope" required><?php echo htmlspecialchars($cert['scope']); ?></textarea>
            </div>
            <div class="form-row" style="grid-template-columns:1fr 1fr;">
                <div class="field">
                    <label>Issue Date <span class="req">*</span></label>
                    <input type="date" name="issue_date" required value="<?php echo $cert['issue_date']; ?>">
                </div>
                <div class="field">
                    <label>Expiry Date <span class="req">*</span></label>
                    <input type="date" name="expiry_date" required value="<?php echo $cert['expiry_date']; ?>">
                </div>
            </div>
            <div class="field">
                <label>Status <span class="req">*</span></label>
                <select name="status" required>
                    <option value="Active" <?php echo $cert['status']=='Active'?'selected':''; ?>>Active</option>
                    <option value="Inactive" <?php echo $cert['status']=='Inactive'?'selected':''; ?>>Inactive</option>
                    <option value="Suspended" <?php echo $cert['status']=='Suspended'?'selected':''; ?>>Suspended</option>
                </select>
            </div>
            <button type="submit" class="btn btn-gold" style="justify-content:center;width:100%;">Update Certificate</button>
        </form>
        <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>
</body>
</html>