<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Здесь вы можете добавить логику для проверки логина и пароля
    // Например, проверка в базе данных

    if ($username !== "" && $password !== "") {
        echo "<script>alert('Login failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <style>
    body { 
        background-color: #000;
      color: #0f0;
      font-family: "Courier New", monospace;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: relative;
      overflow: hidden;
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: #000;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
      padding: 16px;
      width: 320px;
      position: absolute;
      z-index: 2;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 16px;
      color: #0f0;
      text-align: center;
    }

    .form-group {
      margin-bottom: 8px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 4px;
      color: #0f0;
    }

    input[type="text"],
    input[type="password"] {
      border: none;
      border-bottom: 1px solid #0f0;
      background-color: #000;
      color: #0f0;
      font-family: "Courier New", monospace;
      font-size: 16px;
      padding: 4px;
      width: 100%;
      outline: none;
    }

    input[type="submit"] {
      background-color: #000;
      border: 1px solid #0f0;
      border-radius: 4px;
      color: #0f0;
      cursor: pointer;
      font-family: "Courier New", monospace;
      font-size: 16px;
      padding: 8px;
      width: 100%;
    }

    input[type="submit"]:hover {
      background-color: #0f0;
      color: #000;
    }
  </style>
</head>
<body>
    <canvas id="matrixCanvas" style="position: absolute; z-index: 1;"></canvas>
  <div class="container">
    <h2>Login Form</h2>
    <form id="loginForm" method="POST" action="">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <input type="submit" value="Login">
    </form>
  </div>

  <script>
    var canvas = document.getElementById('matrixCanvas');
    var ctx = canvas.getContext('2d');

    canvas.height = window.innerHeight;
    canvas.width = window.innerWidth;

    var characters = '0123456789ABCDEF'; 
    characters = characters.split('');

    var fontSize = 10;
    var columns = canvas.width / fontSize;

    var drops = [];
    for (var i = 0; i < columns; i++) {
      drops[i] = 1;
    }

    function draw() {
      ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      ctx.fillStyle = '#0f0';
      ctx.font = fontSize + 'px monospace';

      for (var i = 0; i < drops.length; i++) {
        var text = characters[Math.floor(Math.random() * characters.length)];
        ctx.fillText(text, i * fontSize, drops[i] * fontSize);

        if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
          drops[i] = 0;
        }

        drops[i]++;
      }
    }

    setInterval(draw, 33);
  </script>
</body>
</html>
