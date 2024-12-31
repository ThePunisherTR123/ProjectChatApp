<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Temel stil */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg,rgb(255, 60, 60),rgb(255, 67, 67),rgb(255, 102, 0)); /* Dinamik arka plan */
            background-size: 400% 400%;
            animation: gradientBackground 10s ease infinite; /* Arka plan animasyonu */
        }

        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(50px);
            opacity: 0;
            animation: slideIn 1s forwards;
            animation-delay: 0.5s; /* Geç başlaması için */
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 1s forwards;
            animation-delay: 1s; /* Başlık animasyonu */
        }

        /* Başlık Fade-In Animasyonu */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Form ve buton animasyonları */
        label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input, select, button {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        input:focus, select:focus {
            border-color:rgb(84, 167, 255);
            outline: none;
            box-shadow: 0 0 10px rgb(78, 163, 255);
        }

        button {
            background-color:rgb(64, 156, 255);
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            opacity: 0;
            animation: fadeIn 1s forwards;
            animation-delay: 1.5s; /* Buton animasyonu */
        }

        button:hover {
            background-color:rgb(0, 123, 255);
        }

        button:active {
            background-color:rgb(17, 98, 179);
        }

        .success-message, .error-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
            animation: fadeIn 1s forwards;
        }

        .success-message {
            background-color: #28a745;
            color: white;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
        }

        /* Form animasyonu */
        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Button hover efekt */
        button {
            position: relative;
            overflow: hidden;
        }

        button:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(0, 0, 0, 0.4);
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
            border-radius: 50%;
            animation: pulse 0.6s ease-out;
        }

        button:hover:before {
            animation: none;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0;
            }
        }

    </style>
</head>

<body>
<?= $this->include('header'); ?>
<form method="POST" action="<?= base_url('admin/update_user/' . $user['id']); ?>">
    <label for="username">Kullanıcı Adı:</label>
    <input type="text" id="username" name="username" value="<?= esc($user['username']) ?>" required>

    <label for="email">E-posta:</label>
    <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" required>

    <label for="role">Rol:</label>
    <select name="role" id="role">
        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Kullanıcı</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>

    <button type="submit">Güncelle</button>
</form>

<script>
        // Formun submit olayını yakalayalım ve başarılı bir güncelleme işlemi için animasyon ekleyelim
        document.getElementById('updateUserForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Formun gerçek submit olmasını engelle

            // Hedef URL'yi alın
            const formAction = this.action;

            // AJAX ile formu gönderelim
            const formData = new FormData(this);

            fetch(formAction, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // JSON olarak yanıt alın
            .then(data => {
                if (data.success) {
                    document.getElementById('successMessage').style.display = 'block';
                    document.getElementById('errorMessage').style.display = 'none';
                    setTimeout(() => {
                        window.location.href = '/admin/users'; // Başarılı işlemin ardından yönlendir
                    }, 2000);
                } else {
                    document.getElementById('errorMessage').style.display = 'block';
                    document.getElementById('successMessage').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('successMessage').style.display = 'none';
            });
        });
    </script>
</body>
</html>
