<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        return view('User.test');
    }
    public function store(Request $request)
    {
        //  dd($request->all());
        $image = $request->file('image');
        $count = 0;
        foreach ($image as $img) {
            $count++;
            $ex = $img->getClientOriginalExtension();
            $filename = time() . ' ' . $count . $ex;
            print($filename);
        }
    }
}
