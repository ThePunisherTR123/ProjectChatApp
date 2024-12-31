<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
</head>
<body>
    <div id="login-container">
        <h2>Giriş Yap</h2>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('errors') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/login_process') ?>" method="post">
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" name="email" id="email" placeholder="E-posta adresinizi girin" required>
            </div>

            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" name="password" id="password" placeholder="Şifrenizi girin" required>
            </div>

            <button type="submit" class="btn">Giriş Yap</button>
        </form>

        <p>Hesabınız yok mu? <a href="<?= base_url('register') ?>">Kayıt Olun</a></p>
    </div>
</body>
</html>
