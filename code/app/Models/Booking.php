<?php

namespace App\Models;

use App\Models\User\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['name', 'type', 'name_service', 'goi', 'weight', 'date', 'note', 'idCus'];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function getCus($id)
    {
        $customer = DB::table('customer')->select('name')->where('id', $id)->get();
        foreach ($customer as $cus) {
            return $cus->name;
        }
    }
    public function getPhone($id)
    {
        $customer = DB::table('customer')->select('phone')->where('id', $id)->get();
        foreach ($customer as $cus) {
            return $cus->phone;
        }
    }
}
