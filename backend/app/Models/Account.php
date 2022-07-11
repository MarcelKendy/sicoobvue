<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'cpf_cnpj';
    protected $keyType = 'string';
    public $incrementing = false;
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('role');
    }
}
