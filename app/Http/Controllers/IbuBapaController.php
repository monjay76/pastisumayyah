<?php

namespace App\Http\Controllers;

use App\Models\IbuBapa;
use Illuminate\Http\Request;

class IbuBapaController extends Controller
{
    public function index()
    {
        return response()->json(IbuBapa::all());
    }

    public function store(Request $request)
    {
        $ibubapa = IbuBapa::create($request->all());
        return response()->json(['message' => 'Ibu bapa berjaya didaftarkan', 'data' => $ibubapa]);
    }

    public function show($id)
    {
        return response()->json(IbuBapa::with('murid')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $ibubapa = IbuBapa::findOrFail($id);
        $ibubapa->update($request->all());
        return response()->json(['message' => 'Maklumat ibu bapa dikemas kini']);
    }

    public function destroy($id)
    {
        IbuBapa::destroy($id);
        return response()->json(['message' => 'Rekod ibu bapa dipadam']);
    }
}
