<?php
namespace App\Model\Table;

use App\Model\Entity\Cotizacion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cotizacion Model
 *
 */
class CotizacionTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('cotizacion');
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
            ->add('codigoCotizacion', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigoCotizacion', 'create');
            
                        
        $validator
            ->add('fechaCotizacion', 'valid', ['rule' => 'date'])
            ->requirePresence('fechaCotizacion', 'create')
            ->notEmpty('fechaCotizacion');

        return $validator;
    }
}
