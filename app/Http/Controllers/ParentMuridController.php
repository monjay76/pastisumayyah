<?php

namespace App\Http\Controllers;

use App\Models\ParentMurid;
use Illuminate\Http\Request;

class ParentMuridController extends Controller
{
    public function index()
    {
        return response()->json(ParentMurid::with(['ibubapa', 'murid'])->get());
    }

    public function store(Request $request)
    {
        $hubungan = ParentMurid::create($request->all());
        return response()->json(['message' => 'Hubungan ibu bapa dan murid ditambah', 'data' => $hubungan]);
    }

    public function destroy($id)
    {
        ParentMurid::destroy($id);
        return response()->json(['message' => 'Hubungan dipadam']);
    }
}
