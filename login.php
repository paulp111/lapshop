<?php
session_start();
include 'db.php';

$conn = OpenCon();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $password_hash);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Falsches Passwort.";
        }
    } else {
        $errors[] = "Kein Benutzer mit dieser E-Mail gefunden.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Login</h1>

        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <label for="email">E-Mail:</label>
            <input type="email" name="email" required>

            <label for="password">Passwort:</label>
            <input type="password" name="password" required>

            <button type="submit">Einloggen</button>
        </form>

        <p>Noch nicht registriert? <a href="register.php">Hier registrieren</a></p>
    </main>
</body>
</html>
