<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MessageModel;

class AdminController extends BaseController
{
    public function index()
    {
        $session = session();

        // Eğer admin değilse, hata mesajı ile birlikte anasayfaya yönlendir
        if ($session->get('role') !== 'admin') {
            return view('alert');
        }

        // Admin sayfasına yönlendirme
        return view('admin/admin');
    }

    public function users()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/users', $data);
    }

    

    public function messages()
    {
        $messageModel = new MessageModel();
        $data['messages'] = $messageModel->findAll();
        return view('admin/messages', $data);
    }

    public function addUser()
    {
        return view('admin/add_user');
    }

    public function create_user()
{
    // Form verilerini al
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $password = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT); // Şifreyi hash'leyerek kaydediyoruz
    $role = $this->request->getPost('role'); // Rol bilgisini alıyoruz

    // Kullanıcı verisini veritabanına ekleme
    $userModel = new UserModel();
    $userData = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role' => $role, // Rol bilgisini ekliyoruz
    ];

    $userModel->insert($userData);

    return redirect()->to('/admin/users'); // Kullanıcılar sayfasına yönlendir
}


    public function addMessage()
    {
        return view('admin/add_message');
    }

    public function createMessage()
    {
        $messageModel = new MessageModel();
        $data = $this->request->getPost();

        // Mesaj ekleme işlemi
        $messageModel->save($data);
        return redirect()->to('/admin/messages');
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/admin/users');
    }

    public function editUser($id)
    {
        $userModel = new UserModel();
        
        // Kullanıcıyı ID'ye göre al
        $user = $userModel->find($id);

        // Eğer kullanıcı yoksa, hata mesajı göster
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Kullanıcıyı düzenleme formunu görüntüle
        return view('admin/edit_user', ['user' => $user]);
    }

    // Kullanıcıyı güncelleme işlemi (POST isteği)
    public function updateUser($id)
    {
        $userModel = new UserModel();
        
        // Formdan gelen veriyi al
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];

        // Kullanıcıyı güncelle
        $userModel->update($id, $data); // update metodu, ID'ye göre güncelleme yapar

        // Başarılı bir şekilde güncelleme işlemi tamamlandıktan sonra kullanıcıyı listele veya yönlendir
        return redirect()->to('/admin/users');
    }

    public function deleteMessage($id)
    {
        $messageModel = new MessageModel();
        $messageModel->delete($id);
        return redirect()->to('/admin/messages');
    }
}
