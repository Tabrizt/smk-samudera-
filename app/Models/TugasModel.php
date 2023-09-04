<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tugas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_tugas','deskripsi','file','waktu_mulai','waktu_selesai','guru_mapel_id','pertemuan_id'
    ];

    // Dates
    protected $useTimestamps = true;
}
