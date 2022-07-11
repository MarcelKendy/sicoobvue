<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Carbon\Carbon;

class UploadController extends Controller
{
    public function uploadAssociates(Request $request)
    {
        Account::truncate();  
        return Account::insert($request->toArray());
    }
}
