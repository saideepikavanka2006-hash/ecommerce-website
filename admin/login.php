<?php
include '../includes/db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email belongs to an admin
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        // Start admin session and redirect to dashboard
        $_SESSION['admin_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid credentials or not an admin.</p>";
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    background:linear-gradient(135deg,#4f46e5,#7c3aed,#06b6d4);
}

.login-container{
    width:400px;
    padding:40px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(12px);
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.3);
    border:1px solid rgba(255,255,255,0.2);
    animation:fadeIn 0.7s ease;
}

h2{
    text-align:center;
    color:#fff;
    font-size:34px;
    margin-bottom:30px;
}

label{
    display:block;
    color:#fff;
    font-size:15px;
    margin-bottom:8px;
    font-weight:600;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:20px;
    border:none;
    outline:none;
    border-radius:12px;
    background:#fff;
    font-size:15px;
    transition:.3s;
}

input:focus{
    box-shadow:0 0 12px rgba(255,255,255,.8);
    transform:scale(1.02);
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:12px;
    background:linear-gradient(90deg,#ff512f,#dd2476);
    color:#fff;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(221,36,118,.4);
}

button:active{
    transform:scale(.98);
}

p{
    text-align:center;
    color:#ffdddd;
    margin-bottom:15px;
    font-weight:bold;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(-30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>

</body>
</html>
