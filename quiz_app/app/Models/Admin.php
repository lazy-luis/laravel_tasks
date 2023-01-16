<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['firstname','lastname','email','username','password'];

    public function getUsernameAttribute()
    {
        $username = $this->firstname[0] . $this->lastname;
        return $username;
    }
}
