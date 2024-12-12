<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPass extends Model
{
    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    public $timestamp = false;
    use HasFactory;
    protected $fillable = ['email', 'token', 'created_at'];
}
