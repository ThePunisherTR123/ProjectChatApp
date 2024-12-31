<?php

namespace App\Controllers;

class RegisterController extends BaseController
{
    public function register()
{
    $session = session();

    // Eğer kullanıcı zaten giriş yapmışsa, admin sayfasına yönlendir
    if ($session->get('isLoggedIn')) {
        $role = $session->get('role'); // Kullanıcı rolünü al

        // Eğer kullanıcı adminse admin sayfasına yönlendir
        if ($role === 'admin') {
            return redirect()->to('public/admin');
        } else {
            // Eğer kullanıcı admin değilse ana sayfaya yönlendir
            return redirect()->to('/');
        }
    }

    // Eğer giriş yapılmamışsa, kayıt olma sayfasını göster
    return view('auth/register');
}


    // Diğer kayıt işlemleri...
}
