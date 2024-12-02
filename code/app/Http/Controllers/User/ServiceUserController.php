<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceUserController extends Controller
{
    public function index()
    {
        $service = DB::table('services')->select('*')->get();
        return view('User.service', ['service' => $service]);
    }
}
