<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

        protected $table = "hab_roles";

    const NACIONAL = 'nacional';
    const REGIONAL = 'regional';
    const COMUNAL = 'comunal';

    const ROLE_PROFESION = [
        [
            'role' => 'ENC_NIV_CENTRAL',
            'profesion' => 'INTERNO-MDS',
        ],
        [
            'role' => 'ENC_REG_SEREMI',
            'profesion' => 'INTERNO-MDS',
        ],
        [
            'role' => 'EQ_AS_TEC_NIV_CENTRAL',
            'profesion' => 'EXTERNO-FOSIS',
        ],
        [
            'role' => 'ASSIST_TEC_FOSIS',
            'profesion' => 'EXTERNO-FOSIS',
        ],
        [
            'role' => 'COORD_EJECUTOR',
            'profesion' => 'EXTERNO-FOSIS',
        ],
        [
            'role' => 'PROF_CONSTRUCTIVO',
            'profesion' => 'EXTERNO-FOSIS',
        ],
        [
            'role' => 'PROF_SOCIAL',
            'profesion' => 'EXTERNO-FOSIS',
        ],
    ];

    
}
