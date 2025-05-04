<?php
namespace App\Http\Controllers\Mobile\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function getUser(Request $request, string $id)
    {
        if ($request->expectsJson()) {
            $user = User::find($id);
            if($user == null){
                return response()->json([
                    'message' => 'User tidak ditemukan!'
                ]);
            }
            return response()->json([
                'user' => $user,
            ]);
        }
    }

    function getAllUser(){
        
    }
}