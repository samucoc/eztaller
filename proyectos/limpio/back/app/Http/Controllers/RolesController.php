<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    public function options(Request $request)
    {
        try {
            $roles = Role::where(function ($q) use ($request) {
                if ($request->role_type == 'regional') {
                    $q->where('hierarchy', 3);
                }
            })->get()->map(function ($item) {
                return [
                    'value' => $item->id,
                    'text' => $item->description,
                    'type' => $item->type,
                    'hierarchy' => $item->hierarchy
                ];
            });
            return response()->json([
                "message" => 'ok',
                "type" => 'success',
                "data" => $roles,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "message" => 'Error al intentar obtener los roles',
                "type" => 'error',
            ]);
        }
    }
}
