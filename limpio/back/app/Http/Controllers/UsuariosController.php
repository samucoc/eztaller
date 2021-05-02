<?php

namespace App\Http\Controllers;

use App\Comuna;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use stdClass;

class UsuariosController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $convocatoriaId
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {

        $result = User::getIndex([
            'excluir_user_id' => $request->excluir_user_id,
            'tipo_territorio' => $request->tipo_territorio,
            'role_type' => $request->role_type,
            'user_id' => $request->user_id,
            'comuna_id' => $request->comuna_id,
            'activo' => $request->activo
        ]);
        return response()->json([
            "message" => 'ok',
            "type" => 'success',
            "data" => $result,
        ]);
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            if ($request->role_type == "nacional") {
                $request->territorialidad_id = Comuna::pluck('cod_com_ine')->toArray();
            }
            if ($request->role_type == "regional") {
                $request->territorialidad_id = Comuna::whereIn('cod_reg', $request->territorialidad_id)->pluck('cod_com_ine')->toArray();
            }

            $rules = [
                'rut' => 'required|unique:hab_users',
                'nombre' => 'required',
                'email' => 'required|email|unique:hab_users',
                'password' => 'required|min:6',
                'role_id' => 'required|exists:hab_roles,id',
                'role_type' => 'required',
                'activo' => 'required',
                'territorialidad_id' => 'required_if:role_type,' . Role::REGIONAL . ',' . Role::COMUNAL . '|array',
                'convocatoria_id' => 'required_if:role_type,' . Role::COMUNAL . '|array',
            ];
            $v = Validator::make($request->all(), $rules, [
                'required' => 'Este campo es requerido.',
                'territorialidad_id.required_if' => 'La territorialidad es requerida.',
                'convocatoria_id.required_if' => 'La selección de convotatoria es requerida.',
                'password.min' => 'Este campo debe tener al menos :min caracteres.'
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "type" => "success",
                    "errors" => $v->errors(),
                ]);
            }

            $role = Role::findOrFail($request->role_id);
            $key = array_search($role->name, array_column(Role::ROLE_PROFESION, 'role'));
            if (isset(Role::ROLE_PROFESION[$key]['profesion'])) {
                $profesion = Role::ROLE_PROFESION[$key]['profesion'];
            } else {
                $profesion = 'DESCONOCIDO';
            }

            $user = new User();
            $user->rut = strtoupper($request->rut);
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->clave = '0';
            $user->username = $request->email;
            $user->profesion = $profesion;
            $user->activo = ($request->activo === true) ? 1 : 0;
            $user->save();

            $user->roles()->sync([$request->role_id]);

            // Eliminar las comunas
            DB::delete('delete from hab_user_has_comunas where user_id=?', [
                $user->id
            ]);
            // Eliminar convocatorias
            DB::delete('delete from hab_user_has_convocatorias where user_id=?', [
                $user->id
            ]);

            // Crear comunas
            if (is_array($request->territorialidad_id)) {
                foreach ($request->territorialidad_id as $comuna_id) {
                    $res = DB::insert('insert into hab_user_has_comunas (user_id, comuna_id) values (?, ?)', [
                        $user->id, $comuna_id
                    ]);
                }
            }

            if ($request->role_type !== Role::NACIONAL && $request->role_type !== Role::REGIONAL) {
                // Crear convocatorias
                if (is_array($request->convocatoria_id)) {
                    foreach ($request->convocatoria_id as $convocatoria) {
                        DB::insert('insert into hab_user_has_convocatorias (user_id, convocatoria_id) values (?, ?)', [
                            $user->id, $convocatoria['id']
                        ]);
                    }
                }
            }
            DB::commit();

            return response()->json([
                "code" => 200,
                "message" => 'ok',
                "type" => 'success',
                "data" => $user,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json([
                "message" => 'Error al intentar crear el usuario.',
                "type" => 'danger',
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            if ($request->role_type == "nacional") {
                $request->territorialidad_id = Comuna::pluck('cod_com_ine')->toArray();
            }
            if ($request->role_type == "regional") {
                $request->territorialidad_id = Comuna::whereIn('cod_reg', $request->territorialidad_id)->pluck('cod_com_ine')->toArray();
            }
            $rules = [
                'rut' => 'required|unique:hab_users,rut,' . $id,
                'nombre' => 'required',
                'email' => 'required|email|unique:hab_users,email,' . $id,
                'password' => 'nullable|min:6',
                'role_id' => 'required|exists:hab_roles,id',
                'role_type' => 'required',
                'activo' => 'required',
                'territorialidad_id' => 'required_if:role_type,' . Role::REGIONAL . ',' . Role::COMUNAL . '|array',
                'convocatoria_id' => 'required_if:role_type,' . Role::COMUNAL . '|array',
            ];
            $v = Validator::make($request->all(), $rules, [
                'required' => 'Este campo es requerido.',
                'territorialidad_id.required_if' => 'La territorialidad es requerida.',
                'convocatoria_id.required_if' => 'La selección de convotatoria es requerida.',
                'password.min' => 'Este campo debe tener al menos :min caracteres.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "type" => "success",
                    "errors" => $v->errors(),
                ]);
            }

            $role = Role::findOrFail($request->role_id);
            $key = array_search($role->name, array_column(Role::ROLE_PROFESION, 'role'));
            if (isset(Role::ROLE_PROFESION[$key]['profesion'])) {
                $profesion = Role::ROLE_PROFESION[$key]['profesion'];
            } else {
                $profesion = 'DESCONOCIDO';
            }

            $user = User::find($id);
            $user->rut = strtoupper($request->rut);
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->profesion = $profesion;
            $user->activo = ($request->activo === false) ? 0 : 1;
            $user->save();

            // $convocatoria_id

            $user->roles()->sync([$request->role_id]);

            // Eliminar las comunas
            DB::delete('delete from hab_user_has_comunas where user_id=?', [
                $user->id
            ]);

            // Eliminar convocatorias
            DB::delete('delete from hab_user_has_convocatorias where user_id=?', [
                $user->id
            ]);


            // Crear comunas
            if (is_array($request->territorialidad_id)) {
                foreach ($request->territorialidad_id as $comuna_id) {
                    DB::insert('insert into hab_user_has_comunas (user_id, comuna_id) values (?, ?)', [
                        $user->id, $comuna_id
                    ]);
                }
            }


            if ($request->role_type !== Role::NACIONAL && $request->role_type !== Role::REGIONAL) {
                // Crear convocatorias
                if (is_array($request->convocatoria_id)) {
                    foreach ($request->convocatoria_id as $convocatoria) {
                        DB::insert('insert into hab_user_has_convocatorias (user_id, convocatoria_id) values (?, ?)', [
                            $user->id, $convocatoria['id']
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                "code" => 200,
                "type" => 'success',
                "data" => $user,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json([
                "message" => 'Error al intentar editar el usuario.',
                "type" => 'danger',
            ]);
        }
    }

    public function regionesOptions()
    {
        try {

            return response()->json([
                "message" => 'ok',
                "type" => 'success',
                "data" => Comuna::getRegiones(),
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "message" => 'Error al intentar obtener las regiones',
                "type" => 'error',
            ]);
        }
    }

    public function comunasOptions(Request $request)
    {
        $comuna_id = null;
        if ($request->user_id !== '' && $request->role_type == 'regional') {
            $comuna_id = DB::table('hab_user_has_comunas')->where('user_id', $request->user_id)->pluck('comuna_id')->toArray();
        }
        return response()->json([
            "message" => 'ok',
            "type" => 'success',
            "data" => Comuna::getComunas($comuna_id),
        ]);
    }

    public function convocatoriasOptions(Request $request)
    {
        $comuna_id = null;
        if ($request->user_id !== '' && $request->role_type == 'regional') {
            $comuna_id = DB::table('hab_user_has_comunas')->where('user_id', $request->user_id)->pluck('comuna_id')->toArray();
        }
        return response()->json([
            "message" => 'ok',
            "type" => 'success',
            "data" => Comuna::getComunas($comuna_id),
        ]);
    }

    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'user_id' => 'required|exists:hab_users,id',
                'password_actual' => 'required|min:6',
                'password_nuevo' => 'required|min:6',
            ];
            $v = Validator::make($request->all(), $rules, [
                'required' => 'Este campo es requerido.',
                'min' => 'Este campo debe tener al menos :min caracteres.'
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "type" => "success",
                    "errors" => $v->errors(),
                ]);
            }

            $user = User::find($request->user_id);
            if (!Hash::check($request->password_actual, $user->password)) {
                $errors = new stdClass();
                $errors->password_actual = [
                    'La contraseña actual ingresada es inválida.'
                ];
                return response()->json([
                    "code" => 402,
                    "type" => "success",
                    "errors" => $errors,
                ]);
                return $this->authLogin($user);
            }
            $user->password = Hash::make($request->password_actual);
            $user->save();
            DB::commit();

            return response()->json([
                "code" => 200,
                "message" => 'La contraseña a sido cambiada con éxito.',
                "type" => 'success',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json([
                "message" => 'Error al intentar cambiar la contraseña.',
                "type" => 'danger',
            ]);
        }
    }
}
