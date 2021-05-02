<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\DB;

class SuperUsuarioSeeder extends Seeder
{

    private $usuarios = [
        [
            'rut' => '27102323-5',
            'nombre' => 'JOHEL ALEXANDER CEDIEL TERAN',
            'username' => 'jcediel@actis.cl',
            'email' => 'jcediel@actis.cl',
            'password' => '27102323',
        ],
        [
            'rut' => '15829807-4',
            'nombre' => 'SAMUEL SILVA',
            'username' => 'ssilva@actis.cl',
            'email' => 'ssilva@actis.cl',
            'password' => '15829807',
        ],
    ];

    private $rol = [
        'name' => 'SUPER_USUARIO',
        'description' => 'Super Usuario',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::beginTransaction();
        try {
            // Rol
            $rol = Role::where('name', $this->rol['name'])->first();
            if (!$rol) {
                $rol = new Role();
                $rol->name = $this->rol['name'];
                $rol->description = $this->rol['description'];
                $rol->guard_name = 'api';
                $rol->type = 'nacional';
                $rol->hierarchy = 0;
                $rol->save();
            }
            // Permisos
            $permisos = DB::table('hab_permissions')->get();
            foreach ($permisos as $permiso_item) {
                $count = DB::table('hab_role_has_permissions')
                    ->where('permission_id', $permiso_item->id)
                    ->where('role_id', $rol->id)
                    ->count();
                if ($count == 0) {
                    DB::table('hab_role_has_permissions')->insert([
                        'permission_id' => $permiso_item->id,
                        'role_id' => $rol->id
                    ]);
                }
            }

            foreach ($this->usuarios as $usuario_item) {
                $usuario = User::where('rut', $usuario_item['rut'])->first();
                if (!$usuario) {
                    $usuario = new User();
                    $usuario->username = $usuario_item['username'];
                    $usuario->password = Hash::make($usuario_item['password']);
                    $usuario->clave = 'abc';
                    $usuario->nombre = $usuario_item['nombre'];
                    $usuario->rut = $usuario_item['rut'];
                    $usuario->profesion = 'EXTERNO-ACTIS';
                    $usuario->email = $usuario_item['email'];
                    $usuario->save();
                }
                // Rol
                DB::table('hab_user_has_roles')
                    ->where('role_id', $rol->id)
                    ->where('user_id', $usuario->id)
                    ->delete();

                DB::table('hab_user_has_roles')->insert([
                    'role_id' => $rol->id,
                    'user_id' => $usuario->id,
                    'model_type' => 'App\User',
                ]);

                
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            $this->command->error($e->getMessage());
            DB::rollback();
        }
    }
}
