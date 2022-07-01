<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Commission extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('role');
    }
    public function indicator()
    {
        return $this->belongsTo(User::class, 'indicator_id', 'id')->with('role');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id')->with('role');
    }
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id', 'id')->with('role');
    }
}
