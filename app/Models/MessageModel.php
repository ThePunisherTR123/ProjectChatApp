<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages'; // Tablo adı
    protected $primaryKey = 'id'; // Birincil anahtar
    protected $allowedFields = ['username', 'message']; // İzin verilen alanlar
    protected $useTimestamps = true; // Otomatik zaman damgası kullan
    protected $createdField  = 'created_at'; // `created_at` alanını belirt
}
