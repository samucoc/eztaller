<?
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si estás realizando pruebas y necesitas permitir cualquier origen
        //header('Access-Control-Allow-Origin: *');

        // Pero en producción, especifica tu dominio
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: origin, x-api-key, x-requested-with, content-type, accept, access-control-request-method, access-control-allow-headers, authorization, observe, enctype, content-length, x-csrf-token');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}
