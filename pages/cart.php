<?php
session_start();
include "../includes/db.php";

// Create cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product
if (isset($_POST['add_to_cart'])) {

    $id = (int)$_POST['product_id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
}

// Update quantity
if (isset($_POST['update'])) {

    $id = (int)$_POST['product_id'];
    $qty = (int)$_POST['quantity'];

    if ($qty > 0) {
        $_SESSION['cart'][$id] = $qty;
    } else {
        unset($_SESSION['cart'][$id]);
    }
}

// Remove product
if (isset($_POST['remove'])) {

    $id = (int)$_POST['product_id'];
    unset($_SESSION['cart'][$id]);
}

// Fetch products
$cartProducts = [];
$total = 0;

if (!empty($_SESSION['cart'])) {

    $ids = implode(",", array_keys($_SESSION['cart']));

    $stmt = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cartProducts as $product) {
        $total += $product['price'] * $_SESSION['cart'][$product['id']];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart</title>

<link rel="stylesheet" href="../css/cart.css">
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:linear-gradient(135deg,#6a11cb,#2575fc,#00c9a7);
    min-height:100vh;
    padding:40px;
}

.cart-container{
    max-width:1100px;
    margin:auto;
    background:#fff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

.cart-container h1{
    text-align:center;
    color:#6a11cb;
    margin-bottom:30px;
    font-size:38px;
}

.cart-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:25px;
    padding:20px;
    border-radius:15px;
    background:#f8f9ff;
    transition:.3s;
}

.cart-item:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,.15);
}

.cart-image img{
    width:140px;
    height:180px;
    object-fit:cover;
    border-radius:12px;
}

.cart-details{
    flex:1;
}

.cart-details h2{
    color:#333;
    margin-bottom:10px;
}

.cart-details p{
    color:#ff4081;
    font-size:20px;
    font-weight:bold;
}

.cart-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.cart-actions input{
    width:80px;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
    text-align:center;
}

.update-btn{
    background:#4CAF50;
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.update-btn:hover{
    background:#388E3C;
}

.remove-btn{
    background:#f44336;
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.remove-btn:hover{
    background:#d32f2f;
}

.total{
    text-align:right;
    margin-top:30px;
    color:#6a11cb;
    font-size:26px;
}

.buttons{
    display:flex;
    justify-content:space-between;
    margin-top:30px;
}

.back-btn,
.checkout-btn{
    text-decoration:none;
    padding:15px 25px;
    border-radius:30px;
    color:#fff;
    font-weight:bold;
    transition:.3s;
}

.back-btn{
    background:#2575fc;
}

.checkout-btn{
    background:#ff9800;
}

.back-btn:hover{
    background:#1b5fd3;
}

.checkout-btn:hover{
    background:#f57c00;
}

.empty-cart{
    text-align:center;
    padding:60px;
}

.shop-btn{
    display:inline-block;
    margin-top:20px;
    padding:14px 28px;
    background:#6a11cb;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:bold;
}

.shop-btn:hover{
    background:#4c0fa3;
}

@media(max-width:768px){

.cart-item{
    flex-direction:column;
    text-align:center;
}

.buttons{
    flex-direction:column;
    gap:15px;
}

.back-btn,
.checkout-btn{
    text-align:center;
}

}
</style>
</head>

<body>

<div class="cart-container">

<h1>Your Cart</h1>

<?php if(empty($cartProducts)): ?>

<div class="empty-cart">

<h2>Your cart is empty</h2>

<a href="../index.php" class="shop-btn">
Continue Shopping
</a>

</div>

<?php else: ?>

<?php foreach($cartProducts as $product): ?>

<div class="cart-item">

<div class="cart-image">

<img src="../images/<?= htmlspecialchars($product['image']); ?>">

</div>

<div class="cart-details">

<h2><?= htmlspecialchars($product['name']); ?></h2>

<p>
₹<?= number_format($product['price'],2); ?>
×
<?= $_SESSION['cart'][$product['id']]; ?>
</p>

</div>

<div class="cart-actions">

<form method="POST">

<input
type="hidden"
name="product_id"
value="<?= $product['id']; ?>">

<input
type="number"
name="quantity"
min="1"
value="<?= $_SESSION['cart'][$product['id']]; ?>">

<button
type="submit"
name="update"
class="update-btn">

Update Quantity

</button>

</form>

<form method="POST">

<input
type="hidden"
name="product_id"
value="<?= $product['id']; ?>">

<button
type="submit"
name="remove"
class="remove-btn">

Remove

</button>

</form>

</div>

</div>

<?php endforeach; ?>

<div class="total">

<h2>

Total :

₹<?= number_format($total,2); ?>

</h2>

</div>

<div class="buttons">

<a href="../index.php" class="back-btn">

← Back to Shop

</a>

<a href="checkout.php" class="checkout-btn">

Proceed to Checkout →

</a>

</div>

<?php endif; ?>

</div>

</body>

</html>
