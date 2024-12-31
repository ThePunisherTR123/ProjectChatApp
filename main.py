from flask import Flask, render_template, request, redirect, url_for, session, send_from_directory, jsonify
from flask_socketio import SocketIO, emit
import os
import mimetypes
from flask_cors import CORS
from flask_mysqldb import MySQL
from flask_pymongo import PyMongo
from werkzeug.utils import secure_filename
from bson import ObjectId

# Flask uygulama ve yapılandırma
app = Flask(__name__)
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'my_database'
app.config['UPLOAD_FOLDER'] = 'uploads'
app.config["MONGO_URI"] = "mongodb+srv://azobajkan:123@cluster0.zdv0s.mongodb.net/uploads?retryWrites=true&w=majority&appName=Cluster0"
app.secret_key = 'your_secret_key'
CORS(app, resources={r"/api/*": {"origins": "https://1f7e-161-9-199-131.ngrok-free.app"}})


# Veritabanları
mysql = MySQL(app)
mongo = PyMongo(app)
os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

# Socket.IO yapılandırma
socketio = SocketIO(app, cors_allowed_origins="*")


chat_history = []  # Mesaj geçmişi
users = []

# Yardımcı fonksiyonlar
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif', 'mp4', 'avi'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

def save_to_mongo(file_data):
    """MongoDB'ye dosya bilgilerini kaydeder."""
    mongo.db.assets.insert_one(file_data)

# Routes


@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return "Dosya bulunamadı!", 400

    file = request.files['file']
    if file.filename == '':
        return "Dosya adı boş!", 400

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        file_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        file.save(file_path)

        # MIME türünü belirle
        file_type, _ = mimetypes.guess_type(file_path)
        file_url = f'/uploads/{filename}'

        # MongoDB'ye kaydetme
        file_data = {
            '_id': str(ObjectId()),  # Özgün ID
            'ad': filename,
            'tur': file_type or 'unknown',
            'url': file_url
        }
        save_to_mongo(file_data)

        return jsonify({"url": file_url, "type": file_type}), 200

    return "Dosya türü desteklenmiyor!", 400

@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

@app.route('/save_message', methods=['POST'])
def save_message():
    data = request.get_json()
    username = data.get('username')
    message = data.get('message')

    if not username or not message:
        return jsonify({'status': 'error', 'message': 'Kullanıcı adı veya mesaj eksik!'})

    cursor = mysql.connection.cursor()
    cursor.execute("INSERT INTO messages (username, message) VALUES (%s, %s)", (username, message))
    mysql.connection.commit()
    cursor.close()

    return jsonify({'status': 'success', 'message': 'Mesaj kaydedildi.'})

@app.route('/fetch_messages', methods=['GET'])
def fetch_messages():
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT * FROM messages ORDER BY created_at DESC")
    messages = cursor.fetchall()
    cursor.close()
    return jsonify(messages)

# Socket.IO Events
@socketio.on('connect')
def handle_connect():
    username = session.get('username')
    if username:
        users.append(username)
        emit('message', {'data': f'{username} Bağlandı!'}, broadcast=True)

@socketio.on('send_message')
def handle_chat_message(data):
    """Mesaj gönderildiğinde çağrılır."""
    username = data['username']

    if 'msg' in data:
        # Mesaj metni gönderiliyorsa
        message = data['msg']
        print(f"Gelen mesaj: {message} from {username}")
        # Mesajı tüm istemcilere yayınla
        emit('message', {'data': {'username': username, 'msg': message}}, broadcast=True)

    elif 'file' in data:
        # Dosya gönderiliyorsa
        file_data = data['file']
        print(f"Gelen dosya: {file_data['url']} from {username}")
        # Dosya bilgilerini yalnızca bir kez yayınla
        emit('message', {'file': file_data, 'username': username}, broadcast=True)



@socketio.on('disconnect')
def handle_disconnect():
    username = session.get('username', 'Misafir')
    if username in users:
        users.remove(username)
        emit('message', {'data': f'{username} bağlantıyı kesti.'}, broadcast=True)

if __name__ == '__main__':
    socketio.run(app, host='localhost', port=5000)
