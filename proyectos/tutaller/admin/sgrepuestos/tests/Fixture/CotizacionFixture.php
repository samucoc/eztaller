<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CotizacionFixture
 *
 */
class CotizacionFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cotizacion';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'codigoCotizacion' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigoEmpresa' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigoComprador' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'yonley o sol y valle', 'precision' => null, 'autoIncrement' => null],
        'fechaCotizacion' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'codigoCotizacion' => 1,
            'codigoEmpresa' => 1,
            'codigoComprador' => 1,
            'fechaCotizacion' => '2015-07-14'
        ],
    ];
}
