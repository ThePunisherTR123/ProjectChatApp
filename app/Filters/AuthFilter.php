<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Kullanıcıyı doğrula
        $session = session();
        if (!$session->get('isLoggedIn')) {
            // Eğer kullanıcı giriş yapmamışsa, anasayfaya yönlendir
            return redirect()->to('/register');
        }

        // Eğer kullanıcı admin değilse, hata mesajı göster ve anasayfaya yönlendir
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Bu sayfaya sadece admin olan kullanıcılar erişebilir. Anasayfaya yönlendiriliyorsunuz...');
        }
    }

    public function after(RequestInterface $request, $response, $arguments = null)
    {
        // İşlem sonrası yapılacaklar
    }
}
