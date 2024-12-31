<?php

namespace App\Controllers;

class ErrorController extends BaseController
{
    public function alertWithRedirect()
    {
        $data['message'] = $this->request->getGet('message') ?? "Bir hata oluştu. Ana sayfaya yönlendiriliyorsunuz.";
        $data['redirect_url'] = $this->request->getGet('redirect_url') ?? base_url('/');

        return view('alert', $data);
    }
}
