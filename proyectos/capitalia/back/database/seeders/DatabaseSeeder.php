<?php

use Illuminate\Database\Seeder;
use App\Models\EstadosCiviles;
use App\Models\SubGruposPortafolios;
use App\Models\GruposPortafolios;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('EstadosCivilesTableSeeder');
        $this->call('GruposPortafoliosTableSeeder');
        $this->call('SubGruposPortafoliosTableSeeder');
        $this->call('RegionSeeder');
        $this->call('ProvinceSeeder');
        $this->call('CommuneSeeder');
    }
}

class EstadosCivilesTableSeeder extends Seeder
{
    private $data = [
        'Soltero',
        'Casado',
        'Separación en proceso judicial',
        'Viudo',
        'Concubinato',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $row) {
            $_row = EstadosCiviles::where('nombre', $row)->first();
            if (!$_row) {
                $res = new EstadosCiviles(['nombre' => $row]);
                $res->save();
            }
        }
    }
}

class GruposPortafoliosTableSeeder extends Seeder
{
    private $data = [
                        [ 'nombre' => 'Acciones',
                          'descripcion' =>'Acciones'],
                        [ 'nombre' => 'Criptomonedas',
                          'descripcion' =>'Criptomonedas'],
                    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $row) {
            $res = new GruposPortafolios();
            $res->nombre = $row['nombre'];
            $res->descripcion = $row['descripcion'];
            $res->save();
        }
    }
}

class SubGruposPortafoliosTableSeeder extends Seeder
{
    private $data_acciones = [
                        [ 'nombre' => 'TSLA',
                          'descripcion' =>'Tesla Motors Inc'],
                        [ 'nombre' => 'SPCE',
                          'descripcion' =>'Virgin Galactic Holding Inc'],
                        [ 'nombre' => 'NIO',
                          'descripcion' =>'Nio Inc'],
                        [ 'nombre' => 'COIN',
                          'descripcion' =>'Coinbae Global Inc'],
                      ];

    private $data_crypto = [                 
                        [ 'nombre' => 'XRP',
                          'descripcion' =>'XRP'],
                        [ 'nombre' => 'ADA',
                          'descripcion' =>'ADA'],
                        [ 'nombre' => 'BTC',
                          'descripcion' =>'BTC'],
                        [ 'nombre' => 'MIOTA',
                          'descripcion' =>'MIOTA'],
                        [ 'nombre' => 'ETHER',
                          'descripcion' =>'ETHERIUM'],
                        [ 'nombre' => 'TRX',
                          'descripcion' =>'TRX'],
                        [ 'nombre' => 'EOS',
                          'descripcion' =>'EOS']
                        ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_row = GruposPortafolios::where('nombre', 'Acciones')->get();
        foreach ($this->data_acciones as $row) {
            foreach ($_row as $value) {
                $res = new SubGruposPortafolios();
                $res->grupo_id = $value->id;
                $res->nombre = $row['nombre'];
                $res->descripcion = $row['descripcion'];
                $res->save();
            }
        }
        $_row = GruposPortafolios::where('nombre', 'Criptomonedas')->get();
        foreach ($this->data_crypto as $row) {
            foreach ($_row as $value) {
                $res = new SubGruposPortafolios();
                $res->grupo_id = $value->id;
                $res->nombre = $row['nombre'];
                $res->descripcion = $row['descripcion'];
                $res->save();
            }
        }
    }
}
class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/seeders/sql/regions.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/seeders/sql/provinces.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/seeders/sql/communes.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}