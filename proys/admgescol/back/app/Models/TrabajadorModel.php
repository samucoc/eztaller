<?php

namespace App\Models;

use CodeIgniter\Model;

class TrabajadorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'trabajadores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\Trabajador::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'empresa_id' ,
        'user_id' ,
        'rut' ,
        'dv' ,
        'apellido_paterno' ,
        'apellido_materno' ,
        'nombres' ,
        'nombre_social',
        'fecha_nac' ,
        'nacionalidad' ,
        'cargo_id',
        'sexo_id' ,
        'foto' ,
        'direccion' ,
        'comuna_id' ,
        'telefono' ,
        'email' ,
        'contacto_emergencia' ,
        'telefono_emergencia' ,
        'estado_id'
    ];

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
