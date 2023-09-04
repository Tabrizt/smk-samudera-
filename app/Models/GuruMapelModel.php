<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruMapelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'gurumapel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'guru_id', 	'mapel_id', 	'kelas_id'
    ];

    // Dates
    protected $useTimestamps = true;
}
