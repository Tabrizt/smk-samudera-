<?php

namespace App\Models;

use CodeIgniter\Model;

class AudioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'audio';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul', 'nama_file', 'pengguna_id', 'status_pengguna'
    ];

    // Dates
    protected $useTimestamps = true;
}
