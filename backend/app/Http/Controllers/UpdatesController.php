<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Update;



class UpdatesController extends Controller
{

    public function getUpdates(Request $request)
    {
        $allUpdates = Update::orderBy('date', 'desc')->get();
        return response()->json($allUpdates);
    }

    public function getUpdatesMonth(Request $request)
    {
        $allUpdates = Update::whereRaw('MONTH(CAST(date as date)) = MONTH(CURRENT_TIMESTAMP)')->get();
        return response()->json($allUpdates);
    }

    public function addUpdate(Request $request)
    {
        $newUpdate = new Update();
        $newUpdate->title = $request->title;
        $newUpdate->content = $request->content;
        $newUpdate->date = $request->date;
        $newUpdate->type = $request->type;
        $newUpdate->save();
        return response()->json($newUpdate);
    }

    public function editUpdate(Update $update, Request $request)
    {
        $update->title = $request->title;
        $update->content = $request->content;
        $update->date = $request->date;
        $update->type = $request->type;
        $update->save();
        return response()->json($request);
    }

    public function deleteUpdate(Update $update, Request $request)
    {
        $update->delete();
        return response()->json($update);
    }
}
