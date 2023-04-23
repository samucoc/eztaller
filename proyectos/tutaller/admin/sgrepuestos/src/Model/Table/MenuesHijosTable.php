<?php
namespace App\Model\Table;

use App\Model\Entity\MenuesHijo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MenuesHijos Model
 *
 */
class MenuesHijosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('menues_hijos');
        $this->displayField('mhij_ncorr');
        $this->primaryKey('mhij_ncorr');
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
            ->add('mhij_ncorr', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mhij_ncorr', 'create');
            
        $validator
            ->add('menu_ncorr', 'valid', ['rule' => 'numeric'])
            ->requirePresence('menu_ncorr', 'create')
            ->notEmpty('menu_ncorr');
            
        $validator
            ->add('menu_sub', 'valid', ['rule' => 'numeric'])
            ->requirePresence('menu_sub', 'create')
            ->notEmpty('menu_sub');
            
        $validator
            ->requirePresence('mhij_desc', 'create')
            ->notEmpty('mhij_desc');
            
            
        $validator
            ->requirePresence('mhij_link', 'create')
            ->notEmpty('mhij_link');
            
        $validator
            ->add('mhij_perfil', 'valid', ['rule' => 'numeric'])
            ->requirePresence('mhij_perfil', 'create')
            ->notEmpty('mhij_perfil');
            
        $validator
            ->add('mhij_orden', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('mhij_orden');
            
        $validator
            ->requirePresence('mhij_mostrar', 'create')
            ->notEmpty('mhij_mostrar');

        return $validator;
    }
}
