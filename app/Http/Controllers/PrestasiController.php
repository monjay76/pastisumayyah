<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        return response()->json(Prestasi::with(['guru', 'murid'])->get());
    }

    public function store(Request $request)
    {
        $prestasi = Prestasi::create($request->all());
        return response()->json(['message' => 'Prestasi berjaya direkod', 'data' => $prestasi]);
    }

    public function show($id)
    {
        return response()->json(Prestasi::with(['guru', 'murid'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->update($request->all());
        return response()->json(['message' => 'Rekod prestasi dikemas kini']);
    }

    public function destroy($id)
    {
        Prestasi::destroy($id);
        return response()->json(['message' => 'Rekod prestasi dipadam']);
    }
}
