<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return response()->json(Laporan::with('murid')->get());
    }

    public function store(Request $request)
    {
        $laporan = Laporan::create($request->all());
        return response()->json(['message' => 'Laporan berjaya dijana', 'data' => $laporan]);
    }

    public function show($id)
    {
        return response()->json(Laporan::with('murid')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update($request->all());
        return response()->json(['message' => 'Laporan dikemas kini']);
    }

    public function destroy($id)
    {
        Laporan::destroy($id);
        return response()->json(['message' => 'Laporan dipadam']);
    }
}
