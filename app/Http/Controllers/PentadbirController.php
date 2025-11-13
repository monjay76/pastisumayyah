<?php

namespace App\Http\Controllers;

use App\Models\Pentadbir;
use Illuminate\Http\Request;

class PentadbirController extends Controller
{
    // Papar semua pentadbir
    public function index()
    {
        $pentadbir = Pentadbir::all();
        return response()->json($pentadbir);
    }

    // Tambah pentadbir baru
    public function store(Request $request)
    {
        $pentadbir = Pentadbir::create($request->all());
        return response()->json(['message' => 'Pentadbir berjaya ditambah', 'data' => $pentadbir]);
    }

    // Papar satu pentadbir
    public function show($id)
    {
        $pentadbir = Pentadbir::findOrFail($id);
        return response()->json($pentadbir);
    }

    // Kemas kini maklumat pentadbir
    public function update(Request $request, $id)
    {
        $pentadbir = Pentadbir::findOrFail($id);
        $pentadbir->update($request->all());
        return response()->json(['message' => 'Maklumat pentadbir dikemas kini']);
    }

    // Padam pentadbir
    public function destroy($id)
    {
        Pentadbir::destroy($id);
        return response()->json(['message' => 'Pentadbir dipadam']);
    }

    public function createUser()
    {
        $users = \App\Models\User::whereIn('role', ['guru', 'ibubapa'])->latest()->get();
        return view('pentadbir.daftarAkaun', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:guru,ibubapa',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pentadbir.createUser')->with('success', 'Akaun pengguna berjaya didaftarkan.');
    }

    public function senaraiMurid()
    {
        $murids = \App\Models\Murid::all();
        return view('pentadbir.senaraiMurid', compact('murids'));
    }

}
