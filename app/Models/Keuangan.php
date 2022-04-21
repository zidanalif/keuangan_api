<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = [
        'categorie',
        'description',
        'total',
        'id_user'
    ];
}
