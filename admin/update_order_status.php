<?php
include "../db.php"; // adjust path if needed

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    $status = $_POST["status"];

    // ✅ Validate status to prevent SQL injection
    $allowed_statuses = ["Pending", "Processing", "Shipped", "Delivered", "Cancelled"];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status");
    }

    // ✅ Update query
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        // Redirect back to orders page
        header("Location: orders.php?msg=Status+Updated");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
?>
