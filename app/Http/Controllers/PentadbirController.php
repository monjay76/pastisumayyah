<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Subjek;
use App\Models\Prestasi;
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
                'ID_Guru' => 'required|string|max:255|unique:guru,ID_Guru',
                'namaGuru' => 'required|string|max:255',
                'jawatan' => 'required|string|max:255',
            ]);
        } elseif ($request->role === 'ibubapa') {
            $request->validate([
                'ID_Parent' => 'required|string|max:255|unique:ibubapa,ID_Parent',
                'namaParent' => 'required|string|max:255',
            ]);
        }

        $user = \App\Models\User::create([
            'name' => $request->role === 'guru' ? $request->namaGuru : $request->namaParent,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Get the current logged-in admin's ID from session
        $adminId = session('user')->ID_Admin ?? null;

        // Debug: Check if adminId is null and handle it
        if (!$adminId) {
            // If no admin is logged in, try to get the first admin as fallback
            $firstAdmin = \App\Models\Pentadbir::first();
            $adminId = $firstAdmin ? $firstAdmin->ID_Admin : null;
        }

        if ($request->role === 'guru') {
            \App\Models\Guru::create([
                'ID_Guru' => $request->ID_Guru,
                'namaGuru' => $request->namaGuru,
                'emel' => $request->email,
                'noTel' => $request->noTel,
                'jawatan' => $request->jawatan,
                'kataLaluan' => bcrypt($request->password),
                'diciptaOleh' => $adminId,
            ]);
        } elseif ($request->role === 'ibubapa') {
            \App\Models\IbuBapa::create([
                'ID_Parent' => $request->ID_Parent,
                'namaParent' => $request->namaParent,
                'emel' => $request->email,
                'noTel' => $request->noTel,
                'kataLaluan' => bcrypt($request->password),
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

    public function aktivitiTahunan()
    {
        return view('pentadbir.aktivitiTahunan');
    }

    public function aktivitiTahunanMonth($month)
    {
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'Mei', 6 => 'Jun',
            7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];
        $monthName = $monthNames[$month] ?? 'Bulan Tidak Sah';

        // Fetch images for the month
        try {
            $images = \App\Models\Aktiviti::where('month', $month)->orderBy('tarikh', 'desc')->get();
        } catch (\Throwable $e) {
            $images = collect();
        }

        $selectedMonth = $month;
        return view('pentadbir.aktivitiTahunan', compact('month', 'monthName', 'images', 'selectedMonth'));
    }

    public function prestasiMurid(Request $request)
    {
        try {
            $classes = Murid::distinct()->pluck('kelas')->filter()->sort();
        } catch (\Throwable $e) {
            $classes = collect();
        }
        $selectedClass = $request->query('kelas');
        $selectedStudent = null;
        $students = collect();
        try {
            $subjekList = Subjek::pluck('nama_subjek')->toArray();
        } catch (\Throwable $e) {
            $subjekList = [];
        }
        $subjekList = is_array($subjekList) ? $subjekList : [];
        $selectedSubjek = null;
        $ayatList = [];
        $prestasi = collect();
        try {
            $subjek = Subjek::all(); // For subject management tab
        } catch (\Throwable $e) {
            $subjek = collect();
        }
        $subjek = $subjek instanceof \Illuminate\Database\Eloquent\Collection ? $subjek : collect();

        if ($selectedClass) {
            try {
                $students = Murid::where('kelas', $selectedClass)->orderBy('namaMurid')->get();
            } catch (\Throwable $e) {
                $students = collect();
            }
            $muridId = $request->query('murid');
            if ($muridId) {
                try {
                    $selectedStudent = Murid::find($muridId);
                } catch (\Throwable $e) {
                    $selectedStudent = null;
                }
                $selectedSubjek = $request->query('subjek');
                if ($selectedSubjek) {
                    try {
                        $prestasi = Prestasi::where('MyKidID', $muridId)
                            ->where('subjek', $selectedSubjek)
                            ->get()
                            ->keyBy(function ($item) {
                                return $item->ayat . '_' . $item->penggal;
                            });
                    } catch (\Throwable $e) {
                        $prestasi = collect();
                    }
                    $ayatList = $this->getAyatList($selectedSubjek);
                }
            }
        }

        return view('pentadbir.prestasiMurid', compact('classes', 'selectedClass', 'students', 'selectedStudent', 'subjekList', 'selectedSubjek', 'ayatList', 'prestasi', 'subjek'));
    }

    public function storePrestasi(Request $request)
    {
        $request->validate([
            'MyKidID' => 'required|exists:murid,MyKidID',
            'subjek' => 'required|string',
            'penggal' => 'required|in:Penggal 1,Penggal 2',
            'assessments' => 'required|array',
        ]);

        $myKidID = $request->MyKidID;
        $subjek = $request->subjek;
        $penggal = $request->penggal;

        foreach ($request->assessments as $ayat => $tahapPencapaian) {
            Prestasi::updateOrCreate(
                [
                    'MyKidID' => $myKidID,
                    'subjek' => $subjek,
                    'ayat' => $ayat,
                    'penggal' => $penggal,
                ],
                [
                    'tahapPencapaian' => $tahapPencapaian,
                    'markah' => $this->getMarkahFromTahap($tahapPencapaian),
                ]
            );
        }

        return redirect()->back()->with('success', 'Penilaian prestasi berjaya disimpan.');
    }

    public function senaraiSubjek()
    {
        $subjek = Subjek::all();
        return view('pentadbir.senaraiSubjek', compact('subjek'));
    }

    public function storeSubjek(Request $request)
    {
        $request->validate([
            'nama_subjek' => 'required|string|max:255|unique:subjek,nama_subjek',
        ]);

        Subjek::create($request->all());

        return redirect()->back()->with('success', 'Subjek berjaya ditambah.');
    }

    public function updateSubjek(Request $request, $id)
    {
        $request->validate([
            'nama_subjek' => 'required|string|max:255|unique:subjek,nama_subjek,' . $id,
        ]);

        $subjek = Subjek::findOrFail($id);
        $subjek->update($request->all());

        return redirect()->back()->with('success', 'Subjek berjaya dikemas kini.');
    }

    public function destroySubjek($id)
    {
        Subjek::destroy($id);

        return redirect()->back()->with('success', 'Subjek berjaya dipadam.');
    }

    private function getAyatList($subjek)
    {
        // Senarai surah untuk Pratahfiz (Surah Lazim)
        $subjekLower = strtolower($subjek);
        if ($subjekLower == 'pra tahfiz' || $subjekLower == 'pratahfiz') {
            return [
                'Al-Fatihah', 'An-Nas', 'Al-Falaq', 'Al-Ikhlas', 'Al-Masad',
                'An-Nasr', 'Al-Kafirun', 'Al-Kawthar', 'Al-Ma\'un', 'Quraysh',
                'Al-Fil', 'Al-Humazah', 'Al-\'Asr', 'At-Takathur', 'Al-Qari\'ah',
                'Al-\'Adiyat', 'Al-Zalzalah', 'Al-Bayyinah', 'Al-Qadr'
            ];
        }

        // For demo purposes, limit to first 15 ayat
        $ayatLists = [
            'Surah Al-Mulk' => range(1, 30),
            'Surah Al-Kahf' => range(1, 110),
            'Surah Yasin' => range(1, 83),
            'Surah Ar-Rahman' => range(1, 78),
        ];

        $ayat = $ayatLists[$subjek] ?? range(1, 15);
        return array_slice($ayat, 0, 15);
    }

    private function getMarkahFromTahap($tahap)
    {
        $markahMap = [
            'AM' => 1,
            'M' => 2,
            'SM' => 3,
        ];

        return $markahMap[$tahap] ?? 0;
    }

    public function laporan()
    {
        try {
            // Get all prestasi records with relationships
            $prestasi = Prestasi::with(['murid', 'subject', 'guru'])
                ->orderBy('tarikhRekod', 'desc')
                ->get();

            // Group prestasi by student for better organization
            $prestasiByStudent = $prestasi->groupBy('murid_id');

            // Get summary statistics
            $totalRecords = $prestasi->count();
            $uniqueStudents = $prestasi->pluck('murid_id')->unique()->count();
            $subjects = $prestasi->pluck('subjek')->unique();

        } catch (\Throwable $e) {
            $prestasi = collect();
            $prestasiByStudent = collect();
            $totalRecords = 0;
            $uniqueStudents = 0;
            $subjects = collect();
        }

        return view('pentadbir.laporan', compact('prestasi', 'prestasiByStudent', 'totalRecords', 'uniqueStudents', 'subjects'));
    }
}
