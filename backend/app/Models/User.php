<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = "users";
    protected $primaryKey = "id_user";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'profile', 'role'];
    protected $hidden = ['password'];
}
