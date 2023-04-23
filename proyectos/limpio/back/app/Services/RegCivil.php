<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class RegCivil
{
    /**
     * Devuelve los datos de una persona dado el rut
     * @param $rut
     * @return array|null
     */
    public function getPersonaByRut(string $rut)
    {
        $rut = self::formatRut($rut);
        $arr = explode("-", $rut);
        try {
            $client = new \SoapClient(config('webservices.runificador'), [
                'soap_version' => SOAP_1_2,
                'trace' => true,
                'encoding' => 'UTF-8',
                'exceptions' => true
            ]);
            $data = $client->obtenerPersona([
                'rut' => $arr[0],
                'dv' => $arr[1]
            ])->obtenerPersonaResult;
            if ($data->Estado == 'ERROR') {
                return null;
            }
            return [
                'rut' => $data->RUN . '-' . $data->DV,
                'nombre' => $data->Nombres . ' ' . $data->ApellidoPaterno . ' ' . $data->ApellidoMaterno,
                'genero' => strtoupper($data->Sexo) == 'FEMENINO' ? 'F' : 'M',
                'fecha_nac' => self::formatDate($data->FechaNacimiento),
            ];
        } catch (\Exception $e) {
            $result = DB::select('select * from TST_PERSONAS where rut = ?', [$rut]);
            if (count($result)) {
                $persona = $result[0];
                return [
                    'rut' => $persona->rut,
                    'nombre' => strtoupper($persona->nombre),
                    'genero' => $persona->genero == 'female' ? 'F' : 'M',
                    'fecha_nac' => $persona->fecha_nac,
                ];
            }
        }
        return null;
    }

    public static function calculateAge(string $fechaNac)
    {
        return date_diff(date_create($fechaNac), date_create('today'))->y;
    }

    public static function formatRut(string $rut)
    {
        $rut = preg_replace('/[.\-]/i', '', $rut);
        return strtoupper(substr_replace($rut, "-", -1, 0));
    }

    public static function formatDate(string $value)
    {
        return substr($value, 0, 4) . '-' . substr($value, 4, 2) . '-' . substr($value, 6, 2);
    }
}