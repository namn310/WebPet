<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    protected $table = 'image_products';
    protected $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['idPro', 'image'];
    use HasFactory;
    public function product(){
        return $this->belongsTo(product::class);
    }
}
