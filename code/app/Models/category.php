<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $primaryKey = 'idCat';
    public $timestamp = true;
    protected $fillable = ['name'];

    public function product()
    {
        return $this->belongsTo(category::class);
    }

    public function createCat($request)
    {
        $category = category::create([
            'name' => $request->input('nameDM')
        ]);
        $category->save();
    }
    public function getCategoryName($id)
    {
        $category = category::find($id);
        return $category->name;
    }
}
