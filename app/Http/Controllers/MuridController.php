<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index()
    {
        return response()->json(Murid::with(['ibubapa', 'prestasi', 'kehadiran'])->get());
    }

    public function store(Request $request)
    {
        $murid = Murid::create($request->all());
        return response()->json(['message' => 'Murid berjaya ditambah', 'data' => $murid]);
    }

    public function show($id)
    {
        return response()->json(Murid::with(['prestasi', 'kehadiran'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);
        $murid->update($request->all());
        return response()->json(['message' => 'Maklumat murid dikemas kini']);
    }

    public function destroy($id)
    {
        Murid::destroy($id);
        return response()->json(['message' => 'Rekod murid dipadam']);
    }
}
