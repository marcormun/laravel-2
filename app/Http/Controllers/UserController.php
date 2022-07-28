<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    const SUPER_ADMIN = 3;
    public function superAdminRole ($id) {
        try{
            Log::info('adding super adming role');
            $user = User::query()->find($id);
            if(!isset($user)){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unexistent user',
                    ]
                );
            }
            $user->roles()->attach(self::SUPER_ADMIN);

            
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Permissions updated',
                ]
            );
        }catch(\Exception $exception){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error updating permissions'
                ]
            );
        }
    }
    public function deleteSuperAdminRole ($id) {
        try{
            $user = User::query()->find($id);
            if(!isset($user)){
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Unexistent user',
                    ]
                );
            }
            $user->roles()->detach(SELF::SUPER_ADMIN);
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Permissions updated',
                ]
            );
        }catch(\Exception $exception){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error updating permissions',
                    'error' => $exception
                ]
            );
        }
    }
}
