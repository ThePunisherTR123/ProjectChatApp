<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaj Ekle</title>
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

        #register-container {
            width: 700px;
            max-width: 80%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 1500px;
            display: flex;
            flex-direction: column;
            margin-right: 20%;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        input, textarea {
            resize: none;
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?= $this->include('header'); ?>
    <div id="register-container">
        <h1>Mesaj Ekle</h1>
        <form action="create_message" method="post">
            <label for="username">Kullanıcı Adı:</label>
            <textarea type="text" name="username" id="username" required></textarea><br>

            <label for="message">Mesaj:</label>
            <textarea name="message" id="message" required></textarea><br>

            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
