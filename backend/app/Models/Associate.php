<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    protected $primaryKey = 'cpf_cnpj';
    protected $keyType = 'string';
    public $incrementing = false;
    use HasFactory;
    
}
