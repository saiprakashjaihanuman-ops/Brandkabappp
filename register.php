<?php
include "db.php";

$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : "index.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST["name"];
    $email = $_POST["email"];
    $pass  = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $redirect = isset($_POST["redirect"]) ? $_POST["redirect"] : "index.php";

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);

    if ($stmt->execute()) {
        // Auto-login after registration
        $user_id = $stmt->insert_id;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_name"] = $name;

        header("Location: " . $redirect);
        exit();
    } else {
        $error = "Email already exists";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<?php include "navbar.php"; ?>

<!-- Content -->
<main>
    <h2 style="text-align:center; margin-top:20px;">Register</h2>
    <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>

    <form method="post">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <p>Already have an account? <a href="login.php?redirect=<?= urlencode($redirect) ?>">Login here</a></p>
    </form>
</main>

<!-- Footer -->
<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
