<?php

namespace App\Models;

use CodeIgniter\Model;

class DespachosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'despachos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\Despachos::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'fecha', 'cliente_id', 'origenDespacho', 'destinoDespacho', 
	'cond_estado_1','cond_estado_2','cond_estado_3','cond_estado_4','cond_estado_5',
	'time_estado_1','tine_estado_2','time_estado_3','time_estado_4','time_estado_4',	
	'conductor_id', 'vehiculo_id', 'recogido', 'entregado'    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
