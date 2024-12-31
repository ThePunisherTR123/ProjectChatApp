<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password','role'];
    protected $useTimestamps = true;

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
    $userModel->update_user($id, $data);

    // Başarılı bir şekilde güncelleme işlemi tamamlandıktan sonra kullanıcıyı listele veya yönlendir
    return redirect()->to('/admin/users');
}


}

