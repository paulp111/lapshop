<?php
session_start();
include 'db.php';

$conn = OpenCon();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <input type="button" onclick="window.location='login.php'" class="login" value="Login" style="width: 40%; float: right"/>
    <input type="button" onclick="window.location='admin.php'" class="admin" value="Admin" style="width: 40%; float: right"/>
    <input type="button" onclick="window.location='support.php'" class="support" value="Support" style="width: 40%; float: right"/>
    <input type="button" onclick="window.location='cart.php'" class="cart" value="Cart" style="width: 40%; float: right"/>

    <main class="container">
    <h1>Welcome to Webshop</h1>
    <h2>Products</h2>

    <div class="grid">
    <?php
    $sql = "SELECT id, name, description, image, price FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<article>';
            echo '<img src="imgs/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '" style="width: 50%; max-height: 200px; object-fit: cover;">';
            echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
            echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
            echo '<h3>Preis: €' . number_format($row["price"], 2) . '</h3>';
            echo '</article>';
        }
    } else {
        echo "<p>Keine Produkte verfügbar.</p>";
    }
    ?>
</div>


</body>
</html>

<?php CloseCon($conn); ?>