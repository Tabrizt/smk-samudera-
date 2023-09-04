<?php

namespace App\Models;

use CodeIgniter\Model;

class UjianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ujian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_ujian','waktu_mulai','waktu_selesai','soal','kunci_jawaban','guru_mapel_id','status','pertemuan_id'
    ];

    // Dates
    protected $useTimestamps = true;
}
