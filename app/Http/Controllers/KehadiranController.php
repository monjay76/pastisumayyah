<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        return response()->json(Kehadiran::with('murid')->get());
    }

    public function store(Request $request)
    {
        $kehadiran = Kehadiran::create($request->all());
        return response()->json(['message' => 'Kehadiran berjaya direkod', 'data' => $kehadiran]);
    }

    public function show($id)
    {
        return response()->json(Kehadiran::with('murid')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $kehadiran = Kehadiran::findOrFail($id);
        $kehadiran->update($request->all());
        return response()->json(['message' => 'Rekod kehadiran dikemas kini']);
    }

    public function destroy($id)
    {
        Kehadiran::destroy($id);
        return response()->json(['message' => 'Rekod kehadiran dipadam']);
    }
}
