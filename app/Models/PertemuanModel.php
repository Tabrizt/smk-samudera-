<?php

namespace App\Models;

use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pertemuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'minggu_pertemuan','mapel_id' 
    ];
}
