<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    // Papar senarai murid
    public function index(\Illuminate\Http\Request $request)
    {
        $murid = Murid::orderBy('namaMurid')->get();
        $editMurid = null;
        if ($request->query('edit')) {
            $editMurid = Murid::find($request->query('edit'));
        }
        return view('guru.senaraiMurid', compact('murid', 'editMurid'));
    }

    // Papar murid tertentu
    public function show($id)
    {
        $murid = Murid::with('ibubapa')->find($id);
        if (! $murid) {
            abort(404, 'Murid tidak ditemui');
        }
        return view('guru.profilMurid', compact('murid'));
    }

    // Papar borang edit
    public function edit($id)
    {
        $murid = Murid::find($id);
        if (! $murid) abort(404);
        return view('guru.editMurid', compact('murid'));
    }

    // Kemas kini data
    public function update(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);
        $data = $request->validate([
            'namaMurid' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'tarikhLahir' => 'nullable|date',
            'alamat' => 'nullable|string',
        ]);
        $murid->update($data);
        return redirect()->route('guru.profilMurid', $murid->id)->with('success', 'Maklumat murid dikemaskini');
    }

    // Padam murid
    public function destroy($id)
    {
        $murid = Murid::find($id);
        if (! $murid) abort(404);
        $murid->delete();
        return redirect()->route('guru.senaraiMurid')->with('success', 'Murid dipadam');
    }
}
