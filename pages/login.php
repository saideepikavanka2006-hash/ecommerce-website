<?php
include('../includes/db.php');  // Include the database connection
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: ../index.php"); // Redirect to the main page
        exit();
    } else {
        // Invalid login
        $error_message = "Invalid email or password.";
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Colorful Login</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(-45deg,#ff6b6b,#ff9f43,#6c5ce7,#00cec9,#0984e3);
background-size:400% 400%;
animation:bg 10s ease infinite;
overflow:hidden;
}

@keyframes bg{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

.circle1,.circle2,.circle3{
position:absolute;
border-radius:50%;
filter:blur(5px);
}

.circle1{
width:220px;
height:220px;
background:#ff7675;
top:30px;
left:80px;
opacity:.4;
}

.circle2{
width:280px;
height:280px;
background:#74b9ff;
bottom:20px;
right:80px;
opacity:.4;
}

.circle3{
width:150px;
height:150px;
background:#ffeaa7;
top:60%;
left:40%;
opacity:.4;
}

.container{
width:950px;
display:flex;
background:rgba(255,255,255,.18);
backdrop-filter:blur(20px);
border-radius:25px;
overflow:hidden;
box-shadow:0 15px 40px rgba(0,0,0,.3);
z-index:10;
}

.left{
width:50%;
background:#fff;
display:flex;
justify-content:center;
align-items:center;
padding:30px;
}

.left img{
width:90%;
max-width:380px;
animation:float 3s ease-in-out infinite;
}

@keyframes float{
0%,100%{transform:translateY(0);}
50%{transform:translateY(-15px);}
}

.right{
width:50%;
padding:50px;
color:white;
}

.right h2{
text-align:center;
font-size:40px;
margin-bottom:30px;
text-shadow:2px 2px 8px rgba(0,0,0,.3);
}

label{
display:block;
margin-top:15px;
margin-bottom:8px;
font-size:18px;
font-weight:bold;
}

input{
width:100%;
padding:15px;
border:none;
border-radius:12px;
font-size:16px;
outline:none;
margin-bottom:15px;
transition:.3s;
}

input:focus{
transform:scale(1.03);
box-shadow:0 0 15px white;
}

button{
width:100%;
padding:15px;
border:none;
border-radius:12px;
font-size:20px;
font-weight:bold;
cursor:pointer;
background:linear-gradient(90deg,#ff512f,#dd2476);
color:white;
transition:.4s;
}

button:hover{
transform:translateY(-4px);
box-shadow:0 10px 20px rgba(0,0,0,.3);
}

.error-message{
text-align:center;
margin-top:15px;
font-weight:bold;
color:#fff700;
}

@media(max-width:900px){

.container{
flex-direction:column;
width:95%;
}

.left,.right{
width:100%;
}

}

</style>

</head>

<body>

<div class="circle1"></div>
<div class="circle2"></div>
<div class="circle3"></div>

<div class="container">

<div class="left">
<img src="https://cdn-icons-png.flaticon.com/512/3144/3144456.png" alt="Shopping">
</div>

<div class="right">

<h2>🛒 Welcome Back</h2>

<form method="POST">

<label>Email</label>
<input type="email" name="email" placeholder="Enter your email" required>

<label>Password</label>
<input type="password" name="password" placeholder="Enter your password" required>

<button type="submit" name="login">🚀 Login</button>

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
