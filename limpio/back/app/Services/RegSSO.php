<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;
use SoapClient;

class RegSSO
{

    const SSO_ROL_ADMIN = 1;
    const SSO_ROL_REVISOR = 2;
    const SSO_ROL_OPERADOR = 3;
    const SSO_CODIGO_ESTADO_OK = 1;
    const SSO_CODIGO_ESTADO_ERROR = 0;

    public static function newSSO()
    {
        $SSO_WSDL = config('auth.wsdl');

        if (isset($SSO_WSDL) && !empty($SSO_WSDL)) :
            try {
                $sso = @new SoapClient($SSO_WSDL);
                $sso->__setLocation($SSO_WSDL);
                $sso->estado = 'ok';
                $sso->estado_c = RegSSO::SSO_CODIGO_ESTADO_OK;
                $sso->estado_msg = 'SSO conectado correctamente.';
            } catch (Exception $e) {
                $sso = new \stdClass();
                $sso->estado = 'error';
                $sso->estado_c = RegSSO::SSO_CODIGO_ESTADO_ERROR;
                $sso->estado_msg = 'Error SSO: ' . $e->getMessage();
            }

            if ($sso->estado_c == RegSSO::SSO_CODIGO_ESTADO_OK) :
                $AID = config('auth.AID');
                if (isset($AID) && !empty($AID)) :
                    $sso->roles = isset($sso->ListarRolesAplicacion(array('AID' => config('auth.AID')))->ListarRolesAplicacionResult) ? $sso->ListarRolesAplicacion(array('AID' => config('auth.AID')))->ListarRolesAplicacionResult : null;
                    if (!isset($sso->roles->Roles) || count($sso->roles->Roles->Rol) < 0) :
                        $sso = new \stdClass();
                        $sso->estado = 'error';
                        $sso->estado_c = RegSSO::SSO_CODIGO_ESTADO_ERROR;
                        $sso->estado_msg = 'Error Aplicación: Validar ID de aplicación del SSO, variable "SSO_AID", ya que no tiene ningún Rol asignado en SSO.';
                    endif;
                else :
                    $sso = new \stdClass();
                    $sso->estado = 'error';
                    $sso->estado_c = RegSSO::SSO_CODIGO_ESTADO_ERROR;
                    $sso->estado_msg = 'Error RegSSO: Debe configurar el ambiente del SSO, variable "SSO_AID".';
                endif;
            endif;
        else :
            $sso = new \stdClass();
            $sso->estado = 'error';
            $sso->estado_c = RegSSO::SSO_CODIGO_ESTADO_ERROR;
            $sso->estado_msg = 'Error RegSSO: Debe configurar el ambiente del SSO, variable "SSO_WSDL".';
        endif;
        return $sso;
    }

    public static function getUsuario($rut)
    {
        $respuesta = new \stdClass();
        if (isset($rut) && !empty($rut)) :
            $sso = RegSSO::newSSO();
            $respuesta->usuario = $sso->BuscarUsuario(array('rut' => $rut['username'], 'AID' => config('auth.AID')))->BuscarUsuarioResult;
            if (isset($respuesta->usuario->Estado) && $respuesta->usuario->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->usuario->Detalle) ? 'Advertencia de SSO: ' . $respuesta->usuario->Detalle : 'Advertencia de SSO.';
            endif;
        else :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El RUT es requerido.';
        endif;
        return $respuesta;
    }

    public static function getAutorizar($token)
    {
        $respuesta = new \stdClass();
        if (isset($token) && !empty($token)) :
            $sso = Sso::newSSO();
            $respuesta->autorizar = $sso->Autorizar(array('token' => $token))->AutorizarResult;
            if (isset($respuesta->autorizar->Estado) && $respuesta->autorizar->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->autorizar->Detalle) ? 'Advertencia de SSO: ' . $respuesta->autorizar->Detalle : 'Advertencia de SSO.';
            endif;
        else :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El token es requerido.';
        endif;
        return $respuesta;
    }

    public static function getLogin($rut, $psw)
    {
        $respuesta = new \stdClass();
        if (isset($rut) && isset($psw)) :
            $sso = RegSSO::newSSO();
            $respuesta->login = $sso->Login(array('rut' => $rut['username'], 'clave' => $psw['password'], 'AID' => config('auth.AID')))->LoginResult;
            if (isset($respuesta->login->Estado) && $respuesta->login->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->login->Detalle) ? 'Advertencia de SSO: ' . $respuesta->login->Detalle : 'Advertencia de SSO.';
            endif;
        else :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El token es requerido.';
        endif;
        return $respuesta;
    }

    public static function setCrearUsuario($rut, $nombre, $correo, $clave, $habilitado = true)
    {
        $respuesta = new \stdClass();
        if (!isset($rut) || empty($rut)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El RUT es requerido.';
        elseif (!isset($nombre) || empty($nombre)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El Nombre es requerido.';
        elseif (!isset($correo) || empty($correo)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El Correo es requerido.';
        elseif (!isset($clave) || empty($clave)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: La Clave es requerida.';
        else :
            $sso = RegSSO::newSSO();
            $respuesta->crear = $sso->CrearUsuario(array('Usuario' => array('RUT' => $rut['username'], 'Nombre' => trim($nombre), 'Correo' => trim($correo), 'Clave' => $clave, 'Habilitado' => $habilitado), 'AID' => config('auth.AID')))->CrearUsuarioResult;
            if (isset($respuesta->crear->Estado) && $respuesta->crear->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->crear->Detalle) ? 'Advertencia de SSO: ' . $respuesta->crear->Detalle : 'Advertencia de SSO.';
            endif;
        endif;
        return $respuesta;
    }

    public static function setAsignarRoles($rut, $roles = array())
    {
        $respuesta = new \stdClass();
        if (!isset($rut) || empty($rut)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El RUT es requerido.';
        elseif (!isset($roles) || empty($roles)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: Los Roles son requeridos.';
        else :
            $sso = RegSSO::newSSO();
            $respuesta->asignar = $sso->AsignarRoles(array('rut' => $rut['username'], 'roles' => $roles, 'AID' => config('auth.AID')))->AsignarRolesResult;
            if (isset($respuesta->asignar->Estado) && $respuesta->asignar->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->asignar->Detalle) ? 'Advertencia de SSO: ' . $respuesta->asignar->Detalle : 'Advertencia de SSO.';
            endif;
        endif;
        return $respuesta;
    }

    public static function setEliminarRoles($rut, $roles = array())
    {
        $respuesta = new \stdClass();
        if (!isset($rut) || empty($rut)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El RUT es requerido.';
        elseif (!isset($roles) || empty($roles)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: Los Roles son requeridos.';
        else :
            $sso = RegSSO::newSSO();
            $respuesta->eliminar = $sso->EliminarUsuario(array('rut' => $rut['username'], 'AID' => config('auth.AID')))->EliminarUsuarioResult;
            if (isset($respuesta->eliminar->Estado) && $respuesta->eliminar->Estado == 1) :
                $respuesta->estado = 'Eliminado';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->eliminar->Detalle) ? 'Advertencia de SSO: ' . $respuesta->eliminar->Detalle : 'Advertencia de SSO.';
            endif;
        endif;
        return $respuesta;
    }

    public static function listarRoles($rut, $roles = array())
    {
        $respuesta = new \stdClass();
        if (!isset($rut) || empty($rut)) :
            $respuesta->estado = 'error';
            $respuesta->estado_msg = 'Error Funcion SSO: El RUT es requerido.';
        else :
            $sso = RegSSO::newSSO();
            $respuesta->roles = $sso->ListarRolesUsuario(array('rut' => $rut['username'], 'rol' => 0, 'AID' => config('auth.AID')))->ListarRolesUsuarioResult; // 'rol' => 0 para que traiga todos los roles asociados al rut
            if (isset($respuesta->listarRol->Estado) && $respuesta->listarRol->Estado == 1) :
                $respuesta->estado = 'ok';
            else :
                $respuesta->estado = 'error';
                $respuesta->estado_msg = isset($respuesta->listarRol->Detalle) ? 'Advertencia de SSO: ' . $respuesta->listarRol->Detalle : 'Advertencia de SSO.';
            endif;
        endif;


        return $respuesta;
    }
}
