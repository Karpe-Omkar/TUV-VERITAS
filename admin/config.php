<?php
// Database configuration
define('DB_HOST', '31.22.4.102'); 
define('DB_NAME', 'finixcon_tuvveritas_certificate');
define('DB_USER', 'finixcon_tuvAdmin');
define('DB_PASS', 'MyTesting@');



// Admin credentials (in production, store hashed password)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'TUV@2026');  // Change this!

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection function
function getDB() {
    try {
        return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    } catch (PDOException $e) {
        die("DB Connection failed: " . $e->getMessage());
    }
}
?>