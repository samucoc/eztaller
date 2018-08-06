<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cotizacion Entity.
 */
class Cotizacion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigoCotizacion' => true,
        'codigoEmpresa' => true,
        'fechaCotizacion' => true,
        'codigoComprador'=>true,
    ];
}
