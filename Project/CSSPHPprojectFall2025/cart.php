<?php
session_start();
require_once 'db.php';
$db = new db();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    $stmt = $db->conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $_SESSION['cart'] = [];
    $orderMessage = "Ordered Successfully!";
}

$pageTitle = "Your Cart";
include 'includes/header.php';
?>

<main>
    <section>
        <h2>Your Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <form action="cart.php" method="post">
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <?php $total = $item['price'] * $item['quantity']; ?>
                        <?php $grandTotal += $total; ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo $id; ?>]"
                                       value="<?php echo $item['quantity']; ?>" min="0">
                            </td>
                            <td>$<?php echo $total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p><strong>Grand Total: $<?php echo $grandTotal; ?></strong></p>
                <button type="submit" name="update_cart" class="cta-button">Update Cart</button>
                <button type="submit" name="place_order" class="cta-button">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <?php if (!empty($orderMessage)): ?>
            <p class="success-message"><?php echo $orderMessage; ?></p>
        <?php endif; ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

