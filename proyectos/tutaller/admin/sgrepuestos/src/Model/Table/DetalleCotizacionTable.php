<?php
namespace App\Model\Table;

use App\Model\Entity\DetalleCotizacion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DetalleCotizacion Model
 *
 */
class DetalleCotizacionTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('detalle_cotizacion');
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
            ->add('codigoDetalle', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigoDetalle', 'create')
            ->notEmpty('codigoDetalle');
            
        $validator
            ->add('codigoCotizacion', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigoCotizacion', 'create')
            ->notEmpty('codigoCotizacion');
            
        $validator
            ->add('codigoRepuesto', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigoRepuesto', 'create')
            ->notEmpty('codigoRepuesto');
            
        $validator
            ->add('valorBruto', 'valid', ['rule' => 'numeric'])
            ->requirePresence('valorBruto', 'create')
            ->notEmpty('valorBruto');
            
        $validator
            ->add('IVA', 'valid', ['rule' => 'numeric'])
            ->requirePresence('IVA', 'create')
            ->notEmpty('IVA');
            
        $validator
            ->add('valorNeto', 'valid', ['rule' => 'numeric'])
            ->requirePresence('valorNeto', 'create')
            ->notEmpty('valorNeto');

        return $validator;
    }
}
