<?php
session_start();
include 'db.php'; 

$conn = OpenCon(); // MySQLi-Verbindung herstellen

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Produkt zum Warenkorb hinzufügen
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        $quantity = 1;
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header("Location: cart.php");
    exit();
}

// Produkt aus Warenkorb entfernen
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}

// Warenkorb leeren
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Dein Warenkorb</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Dein Warenkorb</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <p>Dein Warenkorb ist leer.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Menge</th>
                        <th>Preis</th>
                        <th>Gesamt</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $product_id => $quantity):
                        $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $product = $result->fetch_assoc();

                        if ($product):
                            $subtotal = $product['price'] * $quantity;
                            $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= $quantity ?></td>
                        <td>€<?= number_format($product['price'], 2) ?></td>
                        <td>€<?= number_format($subtotal, 2) ?></td>
                        <td><a href="cart.php?remove=<?= $product_id ?>">❌ Entfernen</a></td>
                    </tr>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>

            <h3>Gesamtpreis: €<?= number_format($total_price, 2) ?></h3>
            <a href="cart.php?clear=1" class="secondary">🗑 Warenkorb leeren</a>
            <a href="checkout.php" class="contrast">💳 Zur Kasse</a>
        <?php endif; ?>
        <br><br>
        <a href="index.php">⬅ Zurück zum Shop</a>
    </main>
</body>
</html>

<?php CloseCon($conn); ?>
