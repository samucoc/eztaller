<?php
namespace App\Model\Table;

use App\Model\Entity\Menue;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menues Model
 *
 */
class MenuesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('menues');
        $this->displayField('menu_ncorr');
        $this->primaryKey('menu_ncorr');
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
            ->add('menu_ncorr', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('menu_ncorr', 'create');
            
        $validator
            ->requirePresence('menu_desc', 'create')
            ->notEmpty('menu_desc');
            
        $validator
            ->add('tper_ncorr', 'valid', ['rule' => 'numeric'])
            ->requirePresence('tper_ncorr', 'create')
            ->notEmpty('tper_ncorr');
            
        $validator
            ->add('menu_orden', 'valid', ['rule' => 'numeric'])
            ->requirePresence('menu_orden', 'create')
            ->notEmpty('menu_orden');

        return $validator;
    }
}
