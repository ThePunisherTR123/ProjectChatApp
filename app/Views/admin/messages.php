<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajlar</title>
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
            margin-right: 90px
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        #messages {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 400px;
            overflow-y: scroll;
        }

        #messages li {
            padding: 10px;
            margin-bottom: 5px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        #messages li:nth-child(odd) {
            background: #e9ecef;
        }

        #messages li:nth-child(even) {
            background: #ffffff;
        }

        .btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<?= $this->include('header'); ?>
    <div id="chat-container">
        <h1>Mesajlar</h1>
        <a href="add_message" class="btn">Mesaj Ekle</a>
        <ul id="messages">
            <?php foreach ($messages as $message): ?>
                <li>
                    <strong><?= $message['username'] ?>:</strong> <?= $message['message'] ?>
                    <a href="delete_message/<?= $message['id'] ?>" class="btn btn-danger">Sil</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
