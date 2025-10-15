<?php
require "db.php";

// 🔐 NEW PASSWORD (Change this before running)
$new_password = "brandkabappp"; 

// Hash the password securely
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

// Update first admin (id = 1) OR change WHERE clause to target a specific username
$sql = "UPDATE admins SET password = ? WHERE username = 'brandkabappp' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashed);

if ($stmt->execute()) {
    echo "<h2>✅ Admin password has been reset successfully!</h2>";
    echo "<p>New password: <b>$new_password</b></p>";
    echo "<p><b>⚠️ IMPORTANT:</b> Delete this file immediately for security.</p>";
} else {
    echo "<h2>❌ Error resetting password.</h2>";
}
