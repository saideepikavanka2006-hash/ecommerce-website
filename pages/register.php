<?php
include('../includes/db.php');  // Database connection
session_start();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for users

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $role]);

        // Log the user in after successful registration
        $_SESSION['user_id'] = $conn->lastInsertId();
        header("Location: ../index.php"); // Redirect to the homepage
        exit();
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#6a11cb,#2575fc,#00c9a7);
    background-size:300% 300%;
    animation:gradient 8s ease infinite;
}

@keyframes gradient{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.container{
    width:900px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(15px);
    border-radius:20px;
    overflow:hidden;
    display:flex;
    box-shadow:0 10px 30px rgba(0,0,0,.3);
}

.left{
    width:50%;
    background:#ffffff;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.left img{
    width:100%;
    max-width:350px;
}

.right{
    width:50%;
    padding:45px;
    color:white;
}

.right h2{
    text-align:center;
    margin-bottom:25px;
    font-size:34px;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:8px;
    font-size:18px;
}

input{
    width:100%;
    padding:13px;
    border:none;
    border-radius:10px;
    font-size:16px;
    outline:none;
    margin-bottom:15px;
}

input:focus{
    box-shadow:0 0 10px rgba(255,255,255,0.7);
}

button{
    width:100%;
    padding:14px;
    background:#ff9800;
    color:white;
    border:none;
    border-radius:10px;
    font-size:18px;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    background:#ff6f00;
    transform:scale(1.03);
}

.error-message{
    color:#ffeb3b;
    text-align:center;
    margin-top:15px;
    font-weight:bold;
}

@media(max-width:800px){

.container{
    flex-direction:column;
    width:95%;
}

.left,.right{
    width:100%;
}

.left{
    padding:30px;
}
}
</style>

</head>

<body>

<div class="container">

    <div class="left">
        <img src="https://cdn-icons-png.flaticon.com/512/891/891462.png" alt="Shopping">
    </div>

    <div class="right">

        <h2>Create Account</h2>

        <form method="POST">

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Create a password" required>

            <button type="submit" name="register">Register</button>

        </form>

        <?php if(isset($error_message)): ?>
            <p class="error-message">
                <?= htmlspecialchars($error_message); ?>
            </p>
        <?php endif; ?>

    </div>

</div>

</body>
</html>
