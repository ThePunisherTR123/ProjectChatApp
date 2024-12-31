<?php

namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\Controller;

class MessageController extends Controller
{
    public function saveMessage()
{
    $messageModel = new MessageModel();

    // Verileri al
    $username = $this->request->getPost('username');
    $message = $this->request->getPost('message');

    // Verilerin boş olup olmadığını kontrol et
    if (empty($username) || empty($message)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Kullanıcı adı veya mesaj eksik!']);
    }

    // Verileri veritabanına kaydet
    $data = [
        'username' => $username,
        'message' => $message,
    ];

    if ($messageModel->save($data)) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Mesaj kaydedildi.']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Mesaj kaydedilemedi.']);
    }
}


    public function fetchMessages()
    {
        $messageModel = new MessageModel();
        $messages = $messageModel->findAll();

        return $this->response->setJSON($messages);
    }
}
