<!DOCTYPE html>
<html lang="tr">
<head>
<script src="https://kit.fontawesome.com/e69ef14388.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>"> <!-- Stil dosyasını ekleyin -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Sol menü */
        .sidebar {
            background: solid, #6a11cb 0%, #2575fc 100%);
            width: 250px;
            height: 100vh;
          
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar a {
            color:rgb(0, 0, 0);
            padding: 15px;
            text-decoration: none;
            
            display: block;
            position: center;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        /* Header kısmı */
        .header {
            background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
            
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: white;
            text-decoration: none;
           
            font-size: 18px;
            margin-left: 20px;
        }

        .header a:hover {
            text-decoration: underline;
            
        }

        /* Content alanı */
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Çıkış butonu */
        #logout-link {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
    

        #logout-link:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <!-- Header kısmı -->


    <!-- Sol menü -->
    <div class="sidebar">
        <a href="<?= base_url('admin') ?>"><i class="fa-solid fa-house"></i> Ana Sayfa</a>
        <a href="<?= base_url('admin/users') ?>"><i class="fa-solid fa-user"></i> Kullanıcılar</a>
        <a href="<?= base_url('admin/messages') ?>"><i class="fa-regular fa-message"></i> Mesajlar</a>
        <a href="<?= base_url('admin/add_user') ?>"><i class="fa-solid fa-user-plus"></i> Kullanıcı Ekle</a>
        <a href="<?= base_url('admin/add_message') ?>"><i class="fa-solid fa-plus"></i><i class="fa-regular fa-message"></i> Mesaj Ekle</a>
        <a href="<?= base_url('index.php') ?>"><i class="fa-solid fa-pen"></i> Anlık Mesajlaşma</a>
        <a href="<?= "https://1f7e-161-9-199-131.ngrok-free.app/mongodb/list_assets_ui"?>"><i class="fa-solid fa-pen"></i>MongoDB Yüklenen Dosyalar</a>
    </div>

    <!-- İçerik Alanı -->
    <div class="content">
        <?= $this->renderSection('content') ?> <!-- İçerik burada görüntülenir -->
    </div>
</body>
</html>
