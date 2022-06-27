<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Access;

class User extends Model
{
    use HasFactory;
    public function access()
    {
        return $this->belongsTo(Access::class, 'access_id', 'id');
    }
}
