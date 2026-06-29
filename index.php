<?php
session_start();
include 'includes/db.php'; // Include the database connection

// Fetch products from the database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
 *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:linear-gradient(135deg,#fdfbfb,#ebedee);
    color:#333;
}

/* Header */
header{
    background:linear-gradient(90deg,#6a11cb,#2575fc,#00c9a7);
    padding:18px 40px;
    color:white;
    box-shadow:0 5px 15px rgba(0,0,0,.2);
}

.header-container{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

header h1{
    font-size:32px;
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:bold;
    transition:.3s;
}

nav a:hover{
    color:#ffe082;
}

.logout-button{
    margin-left:20px;
    background:#ff5252;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:30px;
    cursor:pointer;
    font-weight:bold;
}

.logout-button:hover{
    background:#d50000;
}

/* Main */
main{
    padding:40px;
}

main h2{
    text-align:center;
    font-size:40px;
    color:#6a11cb;
    margin-bottom:35px;
}

/* Products */
.product-list{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
}

.product{
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    transition:.3s;
    text-align:center;
    padding:15px;
}

.product:hover{
    transform:translateY(-10px);
    box-shadow:0 15px 30px rgba(0,0,0,.25);
}

.product-image{
    width:100%;
    height:320px;
    object-fit:cover;
    border-radius:12px;
}

.product h3{
    color:#6a11cb;
    margin:15px 0 10px;
    font-size:22px;
}

.product p{
    color:#555;
    margin-bottom:10px;
}

.product h4{
    color:#ff4081;
    font-size:24px;
    margin:12px 0;
}

/* Buttons */
.add-to-cart-button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:30px;
    background:linear-gradient(90deg,#ff9800,#ff5722);
    color:white;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.add-to-cart-button:hover{
    background:linear-gradient(90deg,#ff5722,#ff9800);
    transform:scale(1.03);
}

/* Cart Icon */
.cart-icon{
    width:22px;
    vertical-align:middle;
    margin-right:5px;
}

/* Footer */
footer{
    margin-top:50px;
    background:linear-gradient(90deg,#6a11cb,#2575fc);
    color:white;
    text-align:center;
    padding:18px;
    font-size:16px;
}

/* Responsive */
@media(max-width:768px){

.header-container{
    flex-direction:column;
    gap:15px;
}

nav{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
}

main{
    padding:20px;
}

}
</style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Welcome to Our Store</h1>
            <nav>
                <a href="pages/login.php">Login</a>
                <a href="pages/register.php">Register</a>
                <a href="pages/cart.php" class="cart-link">
                    <img src="images/cart-icon.png" alt="Cart" class="cart-icon">
                    Cart
                </a>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-button">Logout</button>
                </form>
            </nav>
        </div>
    </header>
    <div class="main-container">
        <main>
            <h2>Products</h2>
            <div class="product-list">
                <?php if (empty($products)) : ?>
    <p>No products available.</p>
<?php else : ?>
    <?php foreach ($products as $product) : ?>
        <div class="product">
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p>Price: $<?= number_format($product['price'], 2); ?></p>
            <p><?= htmlspecialchars($product['description']); ?></p>
            <?php if (!empty($product['image'])) : ?>
                <img src="images/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
            <?php endif; ?>
            <form method="POST" action="pages/cart.php">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; <?= date('Y'); ?> Online Store. All rights reserved.</p>
    </footer>
</body>
</html>
