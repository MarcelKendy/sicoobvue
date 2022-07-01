<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Access;
use App\Models\Role;
use App\Models\LogLogin;

class User extends Model
{
    use HasFactory;
    public function access()
    {
        return $this->belongsTo(Access::class, 'access_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->with('department');
    }
}
