<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens;


    protected $fillable = [
        'client_name',
        'client_key',
        'client_secret',
    ];
}
