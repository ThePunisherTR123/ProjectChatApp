<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anlık Mesajlaşma</title>
    <script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <style>
        #logout-link {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        #logout-link:hover {
            background-color: #d32f2f;
        }

        #fullscreen-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #fullscreen-container img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <!-- index.php içerisindeki çıkış yap butonu -->
        <a href="<?= base_url('auth/logout') ?>" id="logout-link">Çıkış Yap</a>

        <div id="chat-header">
            <h2>Anlık Mesajlaşma</h2>
        </div>

        <div id="search-container">
            <input id="search" type="text" placeholder="Mesajlarda ara...">
        </div>

        <ul id="messages"></ul>

        <div id="chat-footer">
            <div id="file-upload-container">
                <label for="fileInput">Dosya Seç</label>
                <input type="file" id="fileInput">
                <button id="uploadFile">Yükle</button>
            </div>

            <div id="chat-input">
                <input id="message" type="text" placeholder="Mesajınızı yazın...">
                <button id="send">Gönder</button>
            </div>
        </div>
    </div>

    <div id="fullscreen-container" onclick="closeFullscreen()"></div>

    <script>
        const socket = io('https://1f7e-161-9-199-131.ngrok-free.app', {
    path: '/api/socket.io',  // Eğer Flask'ta farklı bir path kullanıyorsanız
    transports: ['polling'],  // Polling ve WebSocket'i birlikte kullan
    cors: {
        origin: "*",  // Her yerden gelen isteklere izin verir
        methods: ["GET", "POST"]
    }
});


        const messages = document.getElementById('messages');
        const messageInput = document.getElementById('message');
        const sendButton = document.getElementById('send');
        const fileInput = document.getElementById('fileInput');
        const uploadFileButton = document.getElementById('uploadFile');
        const searchInput = document.getElementById('search');

        const fullscreenContainer = document.getElementById('fullscreen-container');
        const username = "<?= session()->get('user')['username'] ?>";

        function showMessage(data) {
            const li = document.createElement('li');
            li.classList.add('message');

            if (data.msg) {
                li.innerHTML = `<strong>${data.username}:</strong> ${data.msg}`;
            } else if (data.file) {
                const fileType = data.file.type;
                const fileUrl = data.file.url;

                if (fileType.startsWith('image/')) {
                    li.innerHTML = `<strong>${data.username}:</strong><br><img src="${fileUrl}" style="max-width: 100%; border-radius: 5px;" onclick="showFullscreenImage('${fileUrl}')">`;
                } else if (fileType.startsWith('audio/')) {
                    li.innerHTML = `<strong>${data.username}:</strong><br><audio controls src="${fileUrl}" style="width: 100%;"></audio>`;
                } else if (fileType.startsWith('video/')) {
                    li.innerHTML = `<strong>${data.username}:</strong><br><video controls src="${fileUrl}" style="width: 100%;"></video>`;
                } else {
                    li.innerHTML = `<strong>${data.username}:</strong><br><a href="${fileUrl}" download>${fileUrl.split('/').pop()}</a>`;
                }
            }

            messages.appendChild(li);
            messages.scrollTop = messages.scrollHeight;
        }

        

        function showFullscreenImage(imageUrl) {
            fullscreenContainer.innerHTML = `<img src="${imageUrl}" alt="Fullscreen Image">`;
            fullscreenContainer.style.display = 'flex';
        }

        function closeFullscreen() {
            fullscreenContainer.style.display = 'none';
        }

        socket.on('message', function(data) {
            showMessage(data.data || data);
        });

        sendButton.addEventListener('click', function() {
        const message = messageInput.value.trim();

        if (message) {
            // Mesajı soketle sunucuya gönder
            socket.emit('send_message', { username: username, msg: message });
            messageInput.value = '';

            // Mesajı Python backend'e kaydetmek için API'ye gönder
            fetch('https://1f7e-161-9-199-131.ngrok-free.app/api/save_message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: username,  // Kullanıcı adı
                    message: message     // Mesaj
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Mesaj kaydedildi:', data);
                 //   messageInput.value = '';  // Mesaj gönderdikten sonra inputu temizle
                } else {
                    console.error('Mesaj kaydedilemedi:', data.message);
                }
            })
            .catch(error => {
                console.error('Mesaj kaydedilirken hata:', error);
            });
        } else {
            console.error('Mesaj boş olamaz!');
        }
    });

        uploadFileButton.addEventListener('click', function() {
            const file = fileInput.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('file', file);

                fetch('https://1f7e-161-9-199-131.ngrok-free.app/api/upload', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    socket.emit('send_message', { username: username, file: data });
                })
                .catch(error => console.error('Dosya yüklenirken hata:', error));
            }
        });

        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                sendButton.click();
            }
        });

        searchInput.addEventListener('input', function() {
            const searchText = searchInput.value.toLowerCase();
            const messagesList = document.querySelectorAll('#messages li');

            messagesList.forEach(function(li) {
                const messageText = li.textContent.toLowerCase();
                li.style.display = messageText.includes(searchText) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
