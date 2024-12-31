<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcılar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        #chat-container {
            width: 600px;
            max-width: 90%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            margin-right: 50px;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .editbtn{
            padding: 10px 15px;
        background-color: rgb(0, 179, 255); /* Varsayılan arka plan rengi */
        color: white; /* Metin rengi */
        border-radius: 5px; /* Köşeler yuvarlatılmış */
        text-decoration: none; /* Alt çizgi kaldırılmış */
        position: relative; /* Animasyonlar için pozisyon ayarı */
        overflow: hidden; /* Taşmaları gizlemek için */
        transition: all 0.3s ease; /* Geçiş animasyonu */
            
        }
        .btn {
        padding: 10px 15px;
        background-color: rgb(224, 17, 17); /* Varsayılan arka plan rengi */
        color: white; /* Metin rengi */
        border-radius: 5px; /* Köşeler yuvarlatılmış */
        text-decoration: none; /* Alt çizgi kaldırılmış */
        position: relative; /* Animasyonlar için pozisyon ayarı */
        overflow: hidden; /* Taşmaları gizlemek için */
        transition: all 0.3s ease; /* Geçiş animasyonu */
    }

    /* Renk geçişi ve hafif büyüme efekti */
    .btn:hover {
        background-color: rgb(150, 0, 0); /* Yeni arka plan rengi */
        transform: scale(1.05); /* Hafif büyüme */
    }

    /* Dalga animasyonu */
    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.4); /* Dalga rengi */
        border-radius: 50%; /* Dalga efekti daire olur */
        transform: translate(-50%, -50%);
        transition: none;
        opacity: 0;
    }

    .btn:hover::after {
        width: 200%; /* Dalga boyutu */
        height: 200%;
        opacity: 1;
        transition: all 0.6s ease-out; /* Animasyon süresi */
    }
    </style>
</head>
<body>
<?= $this->include('header'); ?>
    <div id="chat-container">
        <h1>Kullanıcılar</h1>
        <a href="add_user" class="btn">Kullanıcı Ekle</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Email</th>
                    <th>Rol</th> <!-- Rol Kolonu Eklendi -->
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td> <!-- Rolü Gösteriyoruz -->
                        <td>
                            <a href="edit_user/<?= $user['id'] ?>" class= "editbtn">Düzenle</a>
                            <a href="delete_user/<?= $user['id'] ?>" class="btn btn-danger">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
