<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MenuesHijo Entity.
 */
class MenuesHijo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'menu_ncorr' => true,
        'menu_sub' => true,
        'mhij_desc' => true,
        'mhij_link' => true,
        'mhij_perfil' => true,
        'mhij_orden' => true,
        'mhij_mostrar' => true,
    ];
}
