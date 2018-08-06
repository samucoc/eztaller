<?php
namespace App\Model\Table;
use App\Model\Entity\Usuarios;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 *
 */
class UsuariosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('usuarios');
        $this->displayField('usu_ncorr');
        $this->primaryKey('usu_ncorr');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
        ->notEmpty('usu_login', 'Ingrese el nombre de Usuario')
        ->notEmpty('usu_pass', 'Ingrese una Contraseña');
        return $validator;
    }
}
