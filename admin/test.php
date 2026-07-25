<?php
$host = '31.22.4.102';
$dbname = 'finixcon_tuvveritas_certificate';
$user = 'finixcon_tuvAdmin';
$pass = 'MyTesting@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    echo "✅ Connected successfully!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>