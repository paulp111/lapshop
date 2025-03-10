<?php
session_start();
include 'db.php';

$conn = OpenCon();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password2 = trim($_POST["password2"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Bitte eine gültige E-Mail-Adresse eingeben.";
    }

    if ($password !== $password2) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Diese E-Mail ist bereits vergeben.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                echo "Registrierung erfolgreich. <a href='login.php'>Zum Login</a>";
                exit();
            } else {
                $errors[] = "Fehler bei der Registrierung.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Registrieren</h1>

        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <label for="username">Benutzername:</label>
            <input type="text" name="username" required>

            <label for="email">E-Mail:</label>
            <input type="email" name="email" required>

            <label for="password">Passwort:</label>
            <input type="password" name="password" required>

            <label for="password2">Passwort wiederholen:</label>
            <input type="password" name="password2" required>

            <button type="submit">Registrieren</button>
        </form>

        <p>Bereits registriert? <a href="login.php">Zum Login</a></p>
    </main>
</body>
</html>
