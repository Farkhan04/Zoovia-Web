<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LupaPasswordController extends Controller
{
    public function index(){
        return view("Admin.LupaPassword");
    }
}
