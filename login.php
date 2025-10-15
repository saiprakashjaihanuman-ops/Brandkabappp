<?php
session_start();
ob_start(); // Buffer output so header() works

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST["email"];
    $pass     = $_POST["password"];
    $redirect = !empty($_POST["redirect"]) ? $_POST["redirect"] : "index.php";

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($pass, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            // ✅ Redirect safely
            header("Location: " . $redirect);
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "No user found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<?php include "navbar.php"; ?>

<!-- Content -->
<main>
    <h2 style="text-align:center; margin-top:20px;">Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>

    <form method="post" action="login.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <!-- ✅ Preserve redirect -->
        <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : 'index.php'; ?>">
        <button type="submit">Login</button>
        <p>Don’t have an account? 
            <a href="register.php?redirect=<?php echo isset($_GET['redirect']) ? urlencode($_GET['redirect']) : 'index.php'; ?>">
                Register here
            </a>
        </p>
    </form>
</main>

<!-- Footer -->
<?php include "footer.php"; ?>
<script src="script.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
