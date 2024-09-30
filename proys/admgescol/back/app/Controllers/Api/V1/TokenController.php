<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class TokenController extends ResourceController
{
    // Method to validate JWT token
    public function validateToken($authHeader)
    {
        
        if (!$authHeader) {
            return $this->failUnauthorized('Authorization header missing');
        }

        $token = $authHeader;

        try {
            // Get the secret key from config or environment
            $secretKey = "s54adf769sd48sd468sadf46";
            
            // Decode and validate the token
            $decoded = JWT::decode($token, keyOrKeyArray: new Key($secretKey, 'HS256'));
            
            // Now you can access the decoded token data
            $userDNI = $decoded->userDNI;
            $role_id = $decoded->role_id;
            
            // You could also perform additional checks here (e.g., expiration)
            
            return $this->respond([
                'status' => 200,
                'userDNI' => $userDNI,
                'role_id' => $role_id
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid token: ' . $e->getMessage());
        }
    }
    
    public function checkToken()
    {
        $payload = $this->request->getJSON();
        $token =  $payload->token;
        $role_id =  $payload->roleSession;
        $userDNI =  $payload->userDNI;
        $secretKey = "s54adf769sd48sd468sadf46";

        try {
            $decoded = JWT::decode($token, keyOrKeyArray: new Key($secretKey, 'HS256'));

            // Verificación adicional
            if ($decoded) {
                // Comprobar si el token ha expirado
                $now = time();
                if ($decoded->exp < $now) {
                    return $this->failUnauthorized('Token has expired');
                }

                // Comprobar si role_id y userDNI coinciden con los valores del token
                if ($decoded->role_id != $role_id || $decoded->userDNI != $userDNI) {
                    return $this->failUnauthorized('Role or UserDNI does not match the token');
                }

                // Si todo es válido, retornar respuesta
                return $this->respond(['status' => 'Token is valid']);
            } else {
                return $this->failUnauthorized('Token is invalid or expired');
            }
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token is invalid or expired');
        }
}

}



?>