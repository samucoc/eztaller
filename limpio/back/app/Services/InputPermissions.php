<?php

namespace App\Services;

use App\User;

class InputPermissions {

    public function permissionsConvocatoria($req)
    {
        $roles = auth()->user()->roles;

        if ($roles === User::ENC_NIV_CENTRAL) {
            return $req;
        } elseif ($roles === User::ENC_REG_SEREMI) {
            return [
                'rut_ate_fosis' => $req['rut_ate_fosis'],
                'nombre_ate_fosis' => $req['nombre_ate_fosis'],
                'email_ate_fosis' => $req['email_ate_fosis'],
                'rut_enc_prog_seremi' => $req['rut_enc_prog_seremi'],
                'nombre_enc_prog_seremi' => $req['nombre_enc_prog_seremi'],
                'email_enc_prog_seremi' => $req['email_enc_prog_seremi']
            ];
        } elseif ($roles === User::COORD_EJECUTOR) {
            return [
                'rut_ejec_const' => $req['rut_ejec_const'],
                'nombre_ejec_const' => $req['nombre_ejec_const'],
                'email_ejec_const' => $req['email_ejec_const'],
                'profesion_ejec_const' => $req['profesion_ejec_const'],
                'rut_ejec_social' => $req['rut_ejec_social'],
                'nombre_ejec_social' => $req['nombre_ejec_social'],
                'email_ejec_social' => $req['email_ejec_social'],
                'profesion_ejec_social' => $req['profesion_ejec_social']
            ];
        }

        return response()->json(['message' => '"No tienes autorización para modificar algunos campos'], 403);
    }
}