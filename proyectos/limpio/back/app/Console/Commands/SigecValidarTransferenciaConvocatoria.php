<?php

namespace App\Console\Commands;

use App\BitEstado;
use App\Convocatoria;
use App\Services\Sigec;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SigecValidarTransferenciaConvocatoria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigec:val-trans-convocatoria';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validar la transferencia de la convocatoria en SIGEC, para acmbiar estado -En selección de familias para diagnosticar-';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //  TODO: obtener las convocatorias con los estados Convocatoria registrada y En Registro de familias potenciales
        $rows = Convocatoria::whereIn('bit_estado_actual_id', [
            BitEstado::CON_REGISTRADA,
            BitEstado::CON_REGISTRO_FAMILIAS,
        ])->get();
        $sigec = new Sigec();

        foreach ($rows as $item) {
            if (!is_null($item->rut_ejecutor)) {
                $sigec_res = $sigec->getInstituciones($item->comunas->first()->cod_reg, $item->anio, $item->rut_ejecutor);
                if (count($sigec_res)) {
                    if ((!is_null($sigec_res[0]['estado_sigec_id'])) && (!is_null($sigec_res[0]['fecha_transferencia'])))
                        if (
                            time() >= strtotime($sigec_res[0]['fecha_transferencia'])
                        ) {
                            $res = $item->cambiarEstado(BitEstado::CON_SELECCION_FAMILIAS, null, null, 1);
                            Log::info('sigec:val-trans-convocatoria / Datos de convocatoria actualizados desde tarea programada: ' . json_encode($res));
                        }
                }
            }
        }
    }
}
