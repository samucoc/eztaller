<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Services\RegSSO;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /*
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $rut = request(['username']);
        $pass = request(['password']);

        if (Configuracion::getValor('SSO_AUTH')) {
            return $this->loginConSSO($rut, $pass);
        } else {
            return $this->loginSinSSO($rut['username'], $pass['password']);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = $this->getUser();
        return response()->json($user);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function payload()
    {
        return response()->json(auth()->payload());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $this->getUser(),
        ]);
    }

    private function getUser()
    {
        $user = auth()->user();
        $permissions = $user->getAllPermissions();
        $user->all_permissions = $permissions->pluck('name');
        return $user;
    }

    private function authLogin(User $user)
    {
        $token = auth()->login($user);
        if ($token) {
            $estado_msg = 'Sesión iniciada';
            Log::info($estado_msg . ' [Usuario: ' . $user['rut'] . ']');
            return $this->respondWithToken($token);
        } else {
            $estado_msg = 'Error en el identificador de la sesión, reintentelo. Si no logra hacerlo contactese con el administrador (administrador@habitabilidad.cl)';
            Log::warning($estado_msg);
            return response()->json([
                'message' => $estado_msg,
                'type' => 'warning',
            ], 200);
        }
    }

    private function loginSinSSO($rut, $password)
    {
        $input = [
            'rut' => $rut,
            'password' => $password,
        ];
        $rules = [
            'rut' => 'required',
            'password' => 'required',
        ];
        $v = Validator::make($input, $rules, [
            'required' => 'El usuario y la contraseña son requeridos.',
        ]);
        if ($v->fails()) {
            return response()->json([
                "message" => $v->errors()->first(),
                'type' => 'warning',
            ], 200);
        }
        // Check username
        $user = User::where('rut', $rut)->first();
        if ($user) {
            // Check password
            if (Hash::check($password, $user->password)) {
                return $this->authLogin($user);
            }
        }
        return response()->json([
            'message' => 'Error de inicio de sesión: usuario desconocido y/o contraseña incorrecta.',
            'type' => 'warning',
        ], 200);

        return response()->json([
            'message' => json_encode($user),
            'type' => 'warning',
        ], 200);
    }
    private function loginConSSO($username, $password)
    {
        //valida en el SSO
        $sso = RegSSO::getLogin($username, $password);
        if ($sso->estado == 'ok') {

            //Buscar el usuario si esta habilitado
            $sso = RegSSO::getUsuario($username);
            if ($sso->estado == 'ok') {
                $SSO_ID_APP = config('auth.Id_Aplicacion');
                $sso_roles = RegSSO::listarRoles($username);
                $app_failed = true;
                foreach ($sso_roles->roles->Roles as $roles) {
                    if (is_object($roles)) {
                        $roles = array($roles);
                    }
                    foreach ($roles as $rol) {
                        $id_app = $rol->Id_Aplicacion;
                        if ($id_app == $SSO_ID_APP) {
                            $desp_rol =  $rol->Nombre;
                            $app_failed = false;
                        }
                    }
                }
                if ($app_failed) {
                    $message = 'Usuario no posee perfil para acceder al sistema. Contactar a contraparte ministerial. (Referencia ID ' . $SSO_ID_APP . ')';
                    Log::error($message . ' - [Usuario: ' . $username['username'] . ']');
                    return response()->json([
                        'message' => $message,
                        'type' => 'warning',
                    ], 200);
                }

                $user = User::where('rut', $username['username'])->first();
                if ($user) {
                    return $this->authLogin($user);
                } else {

                    // Registrar usuario en habitabilidad
                    $user = new User();
                    $user->username = $sso->usuario->Resultado->Usuario->Correo;
                    $user->password = bcrypt($Pas['password']);
                    $user->clave = '0';
                    $user->nombre = $sso->usuario->Resultado->Usuario->Nombre;
                    $user->rut = $username['username'];
                    $user->profesion = $sso->usuario->Resultado->Usuario->Tipo;
                    $user->email = $sso->usuario->Resultado->Usuario->Correo;
                    $user->save();

                    $id_insert_users = $user->id;

                    Log::info('Usuario registrado - [Usuario: ' . $username['username'] . ']');

                    $sql = "SELECT id FROM hab_roles WHERE description like '%$desp_rol%'";
                    $id_rol_busco = DB::select($sql);
                    if (count($id_rol_busco)) {
                        $role_id = $id_rol_busco[0];
                        $new_user_roles = [
                            'role_id' => $role_id->id,
                            'model_type' => 'App\User',
                            'user_id' => $id_insert_users
                        ];
                    }
                    DB::table('hab_user_has_roles')->insert($new_user_roles);
                    Log::info('Rol registrado - ' . json_encode($new_user_roles) . ' - [Usuario: ' . $username['username'] . ']');

                    $query = "  SELECT comuna_id 
                                FROM hab_user_has_comunas A
                                JOIN hab_users B ON (A.user_id = B.id)
                                JOIN hab_roles C ON (B.id = C.id AND description like '%$desp_rol%')";
                    $result = DB::select($query);
                    $cart = array();
                    foreach ($result as $data) {
                        $id_com = $data->{'comuna_id'};
                        DB::table('hab_user_has_comunas')->insert(['comuna_id' => $id_com, 'user_id' => $id_insert_users]);
                        Log::info('Comuna vinculada - ID ' . $id_com . ' - [Usuario: ' . $username['username'] . ']');
                    }
                    $user = User::where('rut', $username['username'])->first();
                    if ($user) {
                        return $this->authLogin($user);
                    }
                }
            } else {
                Log::warning($sso->estado_msg . ' [Usuario: ' . $username['username'] . ']');
                return response()->json([
                    'message' => $sso->estado_msg,
                    'type' => 'warning',
                ], 200);
            }
        } else {
            Log::warning($sso->estado_msg . ' [Usuario: ' . $username['username'] . ']');
            return response()->json([
                'message' => $sso->estado_msg,
                'type' => 'warning',
            ], 200);
        }
    }
}
