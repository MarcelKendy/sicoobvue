<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Associate;


class UploadController extends Controller
{
    public function uploadAssociates(Request $request)
    {
        Associate::truncate();
        return Associate::insert($request->toArray());
    }
}
