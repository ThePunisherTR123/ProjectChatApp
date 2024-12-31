<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=<?= base_url('/') ?>"> <!-- 5 saniye sonra anasayfaya yönlendir -->
    <title>Uyarı</title>
</head>
<body>
    <h1>Uyarı!</h1>
    <p>Bu sayfaya sadece admin olan kullanıcılar erişebilir. 5 saniye içinde anasayfaya yönlendiriliyorsunuz...</p>
    <p>Yönlendirilmiyorsanız <a href="<?= base_url('/') ?>">buraya tıklayabilirsiniz</a>.</p>
</body>
</html>
