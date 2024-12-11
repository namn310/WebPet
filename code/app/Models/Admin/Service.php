<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Throwable;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    public $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['id', 'name', 'image'];
    public function createService($request)
    {
        $service = new Service();
        try {
            $service->name = $request->input('nameDM');
            if ($request->hasFile('hinhanh')) {
                $file = $request->file('hinhanh');
                $extension = $file->getClientOriginalExtension(); //lay tep mo rong cua file
                $filename = time() . '.' . $extension;
                $file->move('assets/img-dichvu', $filename);
                $service->image = $filename;
            }
            $service->save();
        } catch (Throwable) {
            return redirect(route('admin.serviceAddView'))->with('alert', 'Thêm dịch vụ thất bại !');
        }
        return redirect(route('admin.serviceAddView'))->with('alert', 'Thêm dịch vụ thành công !');
    }
    public function deleteService($id)
    {
        $service = Service::find($id);
        if (File::exists('assets/img-dichvu/' . $service->image)) {
            File::delete('assets/img-dichvu/' . $service->image);
        }
        $service->delete();
    }
    public function updateService($id, $request)
    {
        $service = Service::find($id);
        $service->name = $request->input('name');
        if ($request->hasFile('hinhanh')) {
            if (File::exists(asset('assets/img-dichvu/' . $service->image))) {
                File::delete(asset('assets/img-dichvu/' . $service->image));
            }
            $file = $request->file('hinhanh');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(asset('assets/img-dichvu/' . $filename));
            $service->image = $filename;
        }
        $service->update();
    }
}
