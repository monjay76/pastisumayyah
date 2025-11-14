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
            'role' => 'required|in:guru,ibubapa',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'noTel' => 'required|string|max:15',
        ]);

        if ($request->role === 'guru') {
            $request->validate([
                'namaGuru' => 'required|string|max:255',
                'jawatan' => 'required|string|max:255',
            ]);
        } elseif ($request->role === 'ibubapa') {
            $request->validate([
                'namaParent' => 'required|string|max:255',
                'maklumBalas' => 'nullable|string',
            ]);
        }

        $user = \App\Models\User::create([
            'name' => $request->role === 'guru' ? $request->namaGuru : $request->namaParent,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Masukkan data ke jadual spesifik berdasarkan role
        $adminId = \App\Models\Pentadbir::first()->ID_Admin ?? null;
        if ($request->role === 'guru') {
            \App\Models\Guru::create([
                'namaGuru' => $request->namaGuru,
                'emel' => $request->email,
                'noTel' => $request->noTel,
                'jawatan' => $request->jawatan,
                'kataLaluan' => bcrypt($request->password),
                'diciptaOleh' => $adminId,
            ]);
        } elseif ($request->role === 'ibubapa') {
            \App\Models\IbuBapa::create([
                'namaParent' => $request->namaParent,
                'emel' => $request->email,
                'noTel' => $request->noTel,
                'kataLaluan' => bcrypt($request->password),
                'maklumBalas' => $request->maklumBalas,
                'diciptaOleh' => $adminId,
            ]);
        }

        return redirect()->route('pentadbir.createUser')->with('success', 'Akaun pengguna berjaya didaftarkan.');
    }

    public function senaraiMurid()
    {
        $murids = \App\Models\Murid::all();
        return view('pentadbir.senaraiMurid', compact('murids'));
    }

    public function profilMurid(Request $request)
    {
        $classes = \App\Models\Murid::distinct('kelas')->pluck('kelas');
        $selectedClass = $request->query('kelas');
        $students = null;
        $selectedStudent = null;

        if ($selectedClass) {
            $students = \App\Models\Murid::where('kelas', $selectedClass)->get();
            $selectedStudentId = $request->query('murid');
            if ($selectedStudentId) {
                $selectedStudent = \App\Models\Murid::find($selectedStudentId);
            }
        }

        return view('pentadbir.profilMurid', compact('classes', 'selectedClass', 'students', 'selectedStudent'));
    }

    public function maklumatGuru(Request $request)
    {
        $gurus = \App\Models\Guru::all();
        $selectedGuru = null;
        $selectedGuruId = $request->query('guru');

        if ($selectedGuruId) {
            $selectedGuru = \App\Models\Guru::find($selectedGuruId);
        }

        return view('pentadbir.maklumatGuru', compact('gurus', 'selectedGuru'));
    }

    public function maklumatIbuBapa(Request $request)
    {
        $parents = \App\Models\IbuBapa::all();
        $selectedParent = null;
        $selectedParentId = $request->query('parent');

        if ($selectedParentId) {
            $selectedParent = \App\Models\IbuBapa::with('murid')->find($selectedParentId);
        }

        return view('pentadbir.maklumatIbuBapa', compact('parents', 'selectedParent'));
    }

}
