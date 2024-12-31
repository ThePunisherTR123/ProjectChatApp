<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function login()
{
    $session = session();

    // Eğer kullanıcı zaten giriş yapmışsa
    if ($session->get('isLoggedIn')) {
        $role = $session->get('role');  // Kullanıcı rolünü al

        // Eğer adminse admin sayfasına yönlendir
        if ($role === 'admin') {
            return redirect()->to('public/admin');
        } else {
            // Admin değilse ana sayfaya yönlendir
            return redirect()->to('/');
        }
    }

    // Eğer giriş yapılmamışsa login formunu göster
    return view('auth/register');
}

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

        // Adminse admin sayfasına yönlendir
        if ($user['role'] === 'admin') {
            return redirect()->to('public/admin');
        } else {
            // Admin değilse ana sayfaya yönlendir
            return redirect()->to('/');
        }
    } else {
        // Giriş başarısız, hata mesajı ekle
        session()->setFlashdata('errors', ['E-posta veya şifre hatalı.']);
        return redirect()->back();
    }
}

}
