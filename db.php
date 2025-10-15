<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DB connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "brandkabappp";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Razorpay Keys (test mode for now, replace with live later)
define("RAZORPAY_KEY_ID", "rzp_test_RGFvmNP1FiIT6V"); 
define("RAZORPAY_KEY_SECRET", "vdOFwyxVSu4paU595zJbyGV6");
?>

