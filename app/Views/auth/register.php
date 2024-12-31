<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol / Giriş Yap</title>
    <link rel="stylesheet" href="<?= base_url('css/register.css') ?>">
</head>
<body>

<div class="container">
    <h2>Kayıt Ol / Giriş Yap</h2>

    <?php if (session()->get('isLoggedIn')): ?>
    <script>
        // Eğer kullanıcı zaten giriş yaptıysa, admin sayfasına yönlendir
        window.location.href = '/admin'; 
    </script>
<?php endif; ?>

    <!-- Kayıt Formu -->
    <div id="register-form" class="form-container active">
        <h3>Kayıt Ol</h3>

        <!-- Hata mesajlarını kontrol et -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div>
                <ul class="error-list">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <!-- Kayıt Formu -->
        <form action="<?= base_url('register_process') ?>" method="POST">
            <?= csrf_field() ?>
            
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" value="<?= old('username') ?>" required>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Kayıt Ol</button>
        </form>

        <p>Hesabınız var mı? <a href="javascript:void(0);" onclick="toggleForms()">Giriş Yap</a></p>
    </div>

    <!-- Giriş Formu -->
    <div id="login-form" class="form-container">
        <h3>Giriş Yap</h3>

        <!-- Hata mesajlarını kontrol et -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div>
                <ul class="error-list">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <!-- Giriş Formu -->
        <form action="<?= base_url('login_process') ?>" method="POST">
            <?= csrf_field() ?>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Giriş Yap</button>
        </form>

        <p>Hesabınız yok mu? <a href="javascript:void(0);" onclick="toggleForms()">Kayıt Ol</a></p>
    </div>

</div>

<script>
    // Kayıt başarılı olduğunda alert göster
    <?php if (session()->getFlashdata('success')): ?>
        alert("Çıkış başarılı!");
    <?php endif; ?>

    // Giriş yap butonuna tıklandığında ana sayfaya yönlendir
    <?php if (session()->getFlashdata('login_success')): ?>
        alert("Giriş başarılı!");
        window.location.href = '<?= base_url("/") ?>'; // Ana sayfaya yönlendir
    <?php endif; ?>

    function toggleForms() {
        // Kayıt ve giriş formlarını geçiş yapma
        document.getElementById('register-form').classList.toggle('active');
        document.getElementById('login-form').classList.toggle('active');
    }
</script>





</body>
</html>
