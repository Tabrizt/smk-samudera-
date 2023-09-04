<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'materi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_materi','deskripsi','file','waktu_mulai','waktu_selesai','guru_mapel_id','pertemuan_id'
    ];

    // Dates
    protected $useTimestamps = true;
}
