<?php
require_once 'config.php';

// Check login
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

$db = getDB();
$stmt = $db->query("SELECT * FROM certificates ORDER BY id DESC");
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TUV Veritas</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-wrap { padding: 40px 0; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 30px; }
        .admin-header h1 { font-size: 28px; margin: 0; }
        .admin-table { width: 100%; border-collapse: collapse; background: var(--white); border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--shadow-sm); }
        .admin-table th { background: var(--bg-alt); text-align: left; padding: 14px 18px; font-size: 12px; text-transform: uppercase; letter-spacing: .06em; color: var(--ink-500); }
        .admin-table td { padding: 14px 18px; border-top: 1px solid var(--line); font-size: 14px; }
        .admin-table .actions { display: flex; gap: 8px; }
        .admin-table .actions a { padding: 4px 12px; border-radius: var(--r-pill); font-size: 12px; font-weight: 600; text-decoration: none; }
        .btn-edit { background: var(--brand-blue-50); color: var(--brand-blue-600); }
        .btn-delete { background: #FEF3F2; color: #B42318; }
        .btn-add { background: var(--brand-blue); color: var(--white); padding: 10px 24px; border-radius: var(--r-pill); font-weight: 600; }
        .status-badge-sm { padding: 2px 12px; border-radius: var(--r-pill); font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .status-badge-sm.active { background: #E6F7ED; color: #0D7A4A; }
        .status-badge-sm.inactive { background: #FEF3F2; color: #B42318; }
        .status-badge-sm.suspended { background: #FFFAEB; color: #B54708; }
        .logout-link { font-size: 14px; color: var(--ink-500); }
        .logout-link:hover { color: var(--brand-blue); }
        .empty-msg { padding: 40px; text-align: center; color: var(--ink-500); }
    </style>
</head>
<body>

<div class="container admin-wrap">
    <div class="admin-header">
        <h1>📋 Certificate Registry</h1>
        <div>
            <a href="add.php" class="btn-add">+ Add New Certificate</a>
            <a href="logout.php" class="logout-link" style="margin-left:18px;">Logout</a>
        </div>
    </div>

    <?php if (count($certificates) > 0): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Certificate #</th>
                    <th>Company</th>
                    <th>Standard</th>
                    <th>Expiry</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificates as $cert): ?>
                <tr>
                    <td><?php echo $cert['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($cert['cert_number']); ?></strong></td>
                    <td><?php echo htmlspecialchars($cert['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($cert['standard']); ?></td>
                    <td><?php echo date('d M Y', strtotime($cert['expiry_date'])); ?></td>
                    <td><span class="status-badge-sm <?php echo strtolower($cert['status']); ?>"><?php echo $cert['status']; ?></span></td>
                    <td class="actions">
                        <a href="edit.php?id=<?php echo $cert['id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete.php?id=<?php echo $cert['id']; ?>" class="btn-delete" onclick="return confirm('Delete this certificate?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-msg">No certificates found. <a href="add.php">Add your first one</a>.</div>
    <?php endif; ?>
</div>

</body>
</html>