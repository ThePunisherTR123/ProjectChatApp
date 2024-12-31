from flask import Flask, jsonify, request
from flask_pymongo import PyMongo
import os
from flask import Flask, render_template, request, redirect, url_for, session, send_from_directory, jsonify

from werkzeug.utils import secure_filename

app = Flask(__name__)

# MongoDB Bağlantısı
app.config["MONGO_URI"] = "mongodb+srv://azobajkan:123@cluster0.zdv0s.mongodb.net/uploads?retryWrites=true&w=majority&appName=Cluster0"
mongo = PyMongo(app)

# Dosya yükleme için klasör
UPLOAD_FOLDER = 'uploads'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Geçerli dosya türlerini sınırlama (isteğe bağlı)
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif', 'mp4', 'avi'}

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route('/upload', methods=['POST'])
def upload_file():
    """Dosya yükleme ve MongoDB'ye kaydetme"""
    if 'file' not in request.files:
        return jsonify({"error": "No file part"}), 400
    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "No selected file"}), 400
    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        file.save(filepath)

        # MongoDB'ye kaydet
        asset = {
            "name": filename,
            "url": filepath,
            "type": file.content_type  # Dosya türü (image, video vb.)
        }
        mongo.db.assets.insert_one(asset)

        return jsonify({"message": "File uploaded and saved to MongoDB!"}), 200
    return jsonify({"error": "File type not allowed"}), 400

@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)


@app.route('/list_assets', methods=['GET'])
def list_assets():
    """MongoDB'deki assets koleksiyonundaki verileri listele."""
    assets = mongo.db.assets.find()
    asset_list = []
    for asset in assets:
        asset_list.append({
            "_id": str(asset.get("_id")),
            "name": asset.get("name"),
            "url": asset.get("url"),
            "type": asset.get("type")
        })
    return jsonify(asset_list)

@app.route('/list_assets_ui', methods=['GET'])
def list_assets_ui():
    """MongoDB'deki assets koleksiyonundaki verileri görselleştir."""
    assets = mongo.db.assets.find()
    asset_list = [{
        "_id": str(asset.get("_id")),
        "name": asset.get("ad"),
        "url": asset.get("url"),
        "type": asset.get("tur")
    } for asset in assets]
    
    return render_template('list_assets.html', assets=asset_list) 
    

if __name__ == '__main__':
    # Bu uygulama farklı bir portta çalışacak
    app.run(host='localhost', port=5001)
