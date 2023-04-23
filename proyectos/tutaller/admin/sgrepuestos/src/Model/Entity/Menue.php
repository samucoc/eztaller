<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menue Entity.
 */
class Menue extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'menu_desc' => true,
        'tper_ncorr' => true,
        'menu_orden' => true,
    ];
}
