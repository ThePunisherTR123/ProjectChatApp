<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Kayıt ol formunu göster
    public function register()
    {
        return view('auth/register');
    }

    // Kayıt işlemini gerçekleştiren metot
    public function register_process()
    {
        // Formdan gelen verileri al
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Form doğrulaması (en basit doğrulama)
        if (!$username || !$email || !$password) {
            session()->setFlashdata('errors', ['Tüm alanları doldurduğunuzdan emin olun.']);
            return redirect()->back();  // Hatalar varsa geri döner
        }

        // Şifreyi güvenli şekilde hash'le
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Kullanıcı verisi oluştur
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ];

        // Kullanıcı modelini yükle
        $model = new UserModel();

        // Kullanıcıyı veritabanına kaydet
        if ($model->save($userData)) {
            // Kayıt başarılı, başarılı mesajı ekle ve JS alert ile bildirim gönder
            session()->setFlashdata('success', 'Kayıt başarılı!');
            return view('auth/register', ['alert' => true]);
        } else {
            // Kayıt başarısız, hata mesajı ekle
            session()->setFlashdata('errors', ['Kayıt sırasında bir hata oluştu.']);
            return redirect()->back();  // Hata varsa geri dön
        }
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
            session()->set('user', $user);

            // Kullanıcıyı ana sayfaya yönlendir
            return redirect()->to('/');
        } else {
            // Giriş başarısız, hata mesajı ekle
            session()->setFlashdata('errors', ['E-posta veya şifre hatalı.']);
            return redirect()->back();
        }
    }

    // Çıkış işlemini gerçekleştiren metot
    public function logout()
    {
        // Oturumu sonlandır
        session()->remove('user');
        session()->setFlashdata('success', 'Çıkış başarılı.');

        // Giriş sayfasına veya ana sayfaya yönlendir
        return redirect()->to('/login');
    }
}
