<?php

namespace App\Models\User;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Customer;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['title', 'created_at', 'idCus', 'idPro'];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function product()
    {
        return $this->belongsTo(product::class);
    }
    public function getNameUser($id)
    {
        $userName = Customer::select('name')->where('id', $id)->get();
        foreach ($userName as $name) {
            return $name['name'];
        }
    }
    public function getAvtCus($id)
    {
        $img = Customer::select('image')->where('id', $id)->get();
        foreach ($img as $image) {
            return $image['image'];
        }
    }
}
