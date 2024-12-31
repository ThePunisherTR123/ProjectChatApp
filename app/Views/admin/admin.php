<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
<style>
    body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: linear-gradient(45deg,rgb(141, 198, 255),rgb(111, 183, 255),rgb(102, 194, 255));
    background-size: 400% 400%;
    animation: gradientMove 10s ease infinite;
    font-family: 'Arial', sans-serif;
    overflow: hidden;
    position: relative;
    color: white;
    transition: background-color 0.5s ease-in-out; /* Yumuşak geçiş */
}

/* Gradient animasyonu */
@keyframes gradientMove {
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

/* Admin paneli stil düzenlemeleri */
#admin-panel {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    transition: transform 0.5s ease; /* Yumuşak geçiş */
}

header {
    background: #007bff;
    color: white;
    padding: 20px;
    text-align: center;
    border-radius: 20px 20px 0px 0px;
    transition: background-color 0.5s ease-in-out;
}

header h1 {
    margin: 0;
}

nav ul {
    list-style: none;
    padding: 0;
    text-align: center;
}

nav ul li {
    display: inline-block;
    margin: 10px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    background-color: #0056b3;
    border-radius: 5px;
    transition: background-color 0.3s ease-in-out; /* Geçiş efekti */
}

nav ul li a:hover {
    background-color: #004085;
}

#admin-content {
    padding: 20px;
    text-align: center;
    height: 517px;
    background-color: rgb(0, 0, 0); /* Arka plan rengi */
    position: relative; /* Arka plan ve içerik konumlandırmasını ayarlamak için */
    border-radius: 0px 0px 20px 20px; /* Köşe yuvarlama */
    z-index: 1; /* İçeriğin üstte olması için z-index */
    box-shadow: 0 4px 12px rgba(255, 0, 0, 0.2); /* Yumuşak gölge */
    transition: transform 0.5s ease; /* Yumuşak geçiş */
}

#admin-content::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(175, 210, 210); /* Arka plan rengi */
    background-size: cover;
    filter: blur(10px); /* Arka planı bulanıklaştır */
    z-index: -1; /* Arka planın içerikten altta kalmasını sağlar */
    border-radius: 0px 0px 20px 20px; /* Köşe yuvarlama */
}

#admin-content h2 {
    color: #0d47a1; /* Başlık için koyu mavi */
    margin-bottom: 10px;
}

#admin-content p {
    color: #000; /* Siyah renk */
    font-weight: bold; /* Kalın font */
}

/* Geçişi daha yumuşak yapmak için message animasyonu */
.message {
    position: absolute;
    background-color: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 14px;
    padding: 10px 15px;
    border-radius: 20px;
    white-space: nowrap;
    animation: floatMessage 6s ease-in-out forwards;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
}

/* Mesaj balonlarının yukarı kayma animasyonu */
@keyframes floatMessage {
    0% {
        transform: translateY(100vh);
        opacity: 0;
    }
    20% {
        opacity: 1;
    }
    80% {
        opacity: 1;
    }
    100% {
        transform: translateY(-10%);
        opacity: 0;
    }
}
</style>
</head>
<body>
<?= $this->include('header'); ?>
    <div id="admin-panel">
        <header>
            <h1>Admin Paneli</h1>
            <nav>
                <ul>
                    <li><a href="admin/add_user">Kullanıcı Ekle</a></li>
                    <li><a href="admin/add_message">Mesaj Ekle</a></li>
                    <li><a href="admin/messages">Mesajlar</a></li>
                    <li><a href="admin/users">Kullanıcılar</a></li>
                </ul>
            </nav>
        </header>

        <section id="admin-content">
            <h2>Hoşgeldiniz, Admin!</h2>
            <p>Yapmak istediğiniz işlemi seçebilirsiniz.</p>
        </section>
    </div>
    <script>
    const messages = [
        "Merhaba! Bugün size nasıl yardımcı olabilirim?",
        "Sistemde yeni bir güncelleme mevcut!",
        "Harika bir iş çıkardınız, tebrikler!",
        "Anlık mesajlaşma özelliği test ediliyor.",
        "Yeni bir kullanıcı kaydoldu.",
        "Bize ulaşmak için iletişim formunu doldurabilirsiniz.",
        "Verileriniz başarıyla güncellendi.",
        "Bugün harika bir gün olacak, eminim!",
        "Çalışmalarınızda başarılar dileriz.",
        "Hızlı çözümler için destek ekibimiz hazır.",
        "Öğrenmeye devam edin, geleceğiniz parlak!",
        "Bugün neye odaklanmak istersiniz?",
        "Yeni bir görev başarıyla tamamlandı.",
        "Teknik ekibimiz sorununuzu inceliyor.",
        "En kısa sürede sizinle iletişime geçilecektir.",
        "Bir adım daha ileriye, başarı yakın!",
        "Mesaj gönderimi başarılı oldu.",
        "Bugünkü hedeflerinizi belirlediniz mi?",
        "Bize güveniniz için teşekkür ederiz."
    ];

    // Mesaj balonlarını oluştur ve ekrana yerleştir
    function createMessageBubble() {
        const message = document.createElement('div');
        message.classList.add('message');
        message.textContent = messages[Math.floor(Math.random() * messages.length)];

        // Mesajı rastgele bir yatay konuma yerleştir
        const randomLeft = Math.random() * 80 + 10; // %10 ile %90 arasında
        message.style.left = `${randomLeft}%`;

        // Mesajı body içine ekle
        document.body.appendChild(message);

        // Mesaj balonu animasyonu tamamlandıktan sonra DOM'dan kaldır
        message.addEventListener('animationend', () => {
            message.remove();
        });
    }

    // Daha fazla balon eklemek için aralık süresini ayarlayın
    setInterval(createMessageBubble, 500); // Her 0.5 saniyede bir balon oluştur
</script>

</body>
</html>
