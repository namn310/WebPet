<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GoogleUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'google_clients';
    public $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = ['email', 'name', 'password'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
