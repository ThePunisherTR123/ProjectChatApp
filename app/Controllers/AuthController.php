<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    // Çıkış işlemini gerçekleştiren metot
    public function logout()
    {
        // Oturumu sonlandır
        session()->remove('user');
        session()->remove('isLoggedIn');
        session()->setFlashdata('success', 'Çıkış başarılı.');

        // Çıkış işlemi sonrasında kullanıcıyı kayıt sayfasına yönlendir
        return redirect()->to('/register');
    }

    // Kayıt sayfasını göster
    public function register()
    {
        $session = session();

        // Eğer kullanıcı zaten giriş yaptıysa, admin sayfasına yönlendir
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/admin'); // Kullanıcı giriş yapmışsa admin sayfasına yönlendirilir
        }

        // Eğer kullanıcı giriş yapmamışsa, kayıt sayfası gösterilir
        return view('auth/register');
    }

    // Kayıt işlemini gerçekleştiren metot
    public function register_process()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

        $userModel = new UserModel();
        $userModel->insert([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => 'user' // Varsayılan rol
        ]);

        // Kayıt işlemi başarılıysa, kullanıcıyı giriş yapmaya yönlendir
        return redirect()->to('/register');
    }

    // Giriş işlemini gerçekleştiren metot
    public function login_process()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Giriş başarılı, oturumu başlat
            session()->set([
                'isLoggedIn' => true,  // Giriş durumu
                'user' => $user,       // Kullanıcı bilgileri
                'role' => $user['role'] // Kullanıcı rolü
            ]);

            // Kullanıcıyı admin sayfasına yönlendir
            return redirect()->to('/admin');
        } else {
            // Giriş başarısız, hata mesajı ekle
            session()->setFlashdata('errors', ['E-posta veya şifre hatalı.']);
            return redirect()->back();
        }
    }
    
}
