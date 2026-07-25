<?php
require_once 'config.php';
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
if ($id) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM certificates WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: dashboard.php');
exit;