<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table='banners';
    protected $primaryKey='id';
    public $timestamp=false;
    protected $fillable=['image_home','image_slide','image_booking','image_cart'];
}
