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

<input type="button" onclick="window.location='admin.php'" class="admin" value="Admin Page" style="width: 10%; max-height: 100px; float: right; margin: 10px">
<input type="button" onclick="window.location='login.php'" class="login" value="Login Page" style="width: 10%; max-height: 100px; float: right; margin: 10px">
<input type="button" onclick="window.location='support.php'" class="support" value="Support Ticket" style="width: 10%; max-height: 100px; float: right; margin: 10px">
<input type="button" onclick="window.location='cart.php'" class="cart" value="🛒 Warenkorb" style="width: 10%; max-height: 100px; float: right; margin: 10px">

<main class="container">
    <h1>Welcome to Webshop</h1>
    <h2>Products</h2>

    <div class="grid">
        <?php
        // 1. SQL ABFRAGE: Alle Produkte holen
        $sql = "SELECT id, name, description, price, image FROM products";
        $result = $conn->query($sql);

        // 2. Prüfen, ob Produkte existieren
        if ($result->num_rows > 0) {
            // 3. Jedes Produkt durchgehen
            while ($row = $result->fetch_assoc()) {
                echo '<article>';
                // 4. Produktbild anzeigen
                echo '<img src="imgs/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '" style="width: 100%; max-height: 200px; object-fit: cover;">';
                // 5. Produktinformationen anzeigen
                echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
                echo '<p><strong>Price:</strong> €' . number_format($row["price"], 2) . '</p>';
                
                // 6. In den Warenkorb Button
                echo '<form action="cart.php" method="post">';
                echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                echo '<input type="number" name="quantity" value="1" min="1" required>';
                echo '<input type="submit" name="add_to_cart" value="In den Warenkorb">';
                echo '</form>';

                echo '</article>';
            }
        } else {
            // 7. Falls keine Produkte vorhanden sind
            echo "<p>No products available.</p>";
        }
        ?>
    </div>
</main>

</body>
</html>

<?php CloseCon($conn); ?>
