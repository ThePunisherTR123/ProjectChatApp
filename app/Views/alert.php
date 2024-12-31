<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uyarı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }
        .alert-container {
            text-align: center;
            background-color: #fff;
            padding: 20px 30px;
            border: 1px solid #ffcc00;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .alert-container h1 {
            color: #ff9900;
            margin-bottom: 10px;
        }
        .alert-container p {
            margin: 0;
            font-size: 16px;
        }
    </style>
    <script>
        // 5 saniye sonra yönlendirme
        setTimeout(() => {
            window.location.href = "<?= $redirect_url ?>";
        }, 5000);
    </script>
</head>
<body>
    <div class="alert-container">
        <h1>Yetkisiz Erişim!</h1>
        <p><?= esc($message) ?></p>
        <p>Yönlendirme başlatılıyor...</p>
    </div>
</body>
</html>
