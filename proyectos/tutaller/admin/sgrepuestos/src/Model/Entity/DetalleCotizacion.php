<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DetalleCotizacion Entity.
 */
class DetalleCotizacion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigoDetalle' => true,
        'codigoCotizacion' => true,
        'codigoRepuesto' => true,
        'valorBruto' => true,
        'IVA' => true,
        'valorNeto' => true,
    ];
}
