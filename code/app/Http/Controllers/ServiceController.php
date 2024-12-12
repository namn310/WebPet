<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Service;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service = Service::all();
        return view('Admin.Quanlydichvu', ['service' => $service]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Adddichvu');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service = new Service();
        try {
            $service->createService($request);
        } catch (Throwable) {
            return redirect(route('admin.serviceAddView'))->with('alert', 'Thất bại !');
        }
        return redirect(route('admin.serviceAddView'))->with('alert', 'Thành công !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = DB::table('services')->where('id', $id)->get();
        //dd($service);
        return view('Admin.ChangeDichvu')->with('service', $service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = new Service();
        try {
            $service->updateService($id,$request);
        } catch (Throwable) {
            return redirect(route('admin.service'))->with('alert', 'Thay đổi thất bại');
        }
        return redirect(route('admin.service'))->with('alert', 'Thay đổi thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = new Service();
        try {
            $service->deleteService($id);
        } catch (Throwable) {
            return redirect(route('admin.service'))->with('alert', 'Xóa thất bại');
        }
        return redirect(route('admin.service'))->with('alert', 'Xóa thành công');
    }
}
