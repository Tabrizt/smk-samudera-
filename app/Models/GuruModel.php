<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guru';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama','email','password','foto_profil'
    ];
}
