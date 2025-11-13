<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return response()->json(Guru::all());
    }

    public function store(Request $request)
    {
        $guru = Guru::create($request->all());
        return response()->json(['message' => 'Guru berjaya ditambah', 'data' => $guru]);
    }

    public function show($id)
    {
        return response()->json(Guru::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->update($request->all());
        return response()->json(['message' => 'Maklumat guru dikemas kini']);
    }

    public function destroy($id)
    {
        Guru::destroy($id);
        return response()->json(['message' => 'Rekod guru dipadam']);
    }
}
