<?php
include "db.php";
$id = $_GET["id"];
$conn->query("DELETE FROM coupons WHERE id=$id");
header("Location: coupons.php");
exit();
?>
