<?php

namespace App\Console\Commands;

use App\Convocatoria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SigecActualizarConvocatoria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sigec:act-convocatoria';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar convocatorias con los datos de SIGEC';

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
        $res = Convocatoria::actualizarConvocatoria();
        Log::info('sigec:act-convocatoria / Datos de convocatoria actualizados desde tarea programada: ' . json_encode($res));
    }
}
