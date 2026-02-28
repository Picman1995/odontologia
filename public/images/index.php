<?php
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acesso Proibido</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      background: url('bg.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .content {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .content img {
      max-width: 70%;
      height: auto;
      display: block;
    }
  </style>
</head>
<body>
  <div class="content">
    <img src="403.jpg" alt="403 - Acesso Proibido">
  </div>
</body>
</html>
