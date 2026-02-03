<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Subjek;
use App\Models\Prestasi;
use App\Models\Pentadbir;
use App\Models\Kehadiran;
use App\Models\Feedback;
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
        $data = $request->all();
        if (isset($data['kataLaluan'])) {
            $data['kataLaluan'] = bcrypt($data['kataLaluan']);
        }
        $pentadbir = Pentadbir::create($data);
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
        $data = $request->all();
        if (isset($data['kataLaluan'])) {
            $data['kataLaluan'] = bcrypt($data['kataLaluan']);
        }
        $pentadbir->update($data);
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

    public function senaraiMurid(Request $request)
    {
        try {
            $query = \App\Models\Murid::query();

            // Filter by kelas if provided
            if ($request->filled('kelas')) {
                $query->where('kelas', $request->input('kelas'));
            }

            $murids = $query->get();
            $kelasList = \App\Models\Murid::distinct('kelas')->pluck('kelas')->sort();
        } catch (\Throwable $e) {
            $murids = collect();
            $kelasList = collect();
        }

        return view('pentadbir.senaraiMurid', compact('murids', 'kelasList'));
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
        $feedbacks = collect();

        if ($selectedParentId) {
            $selectedParent = \App\Models\IbuBapa::with('murid')->find($selectedParentId);
            
            // Fetch feedbacks for the selected parent
            if ($selectedParent) {
                $feedbacks = Feedback::where('ID_Parent', $selectedParentId)
                    ->orderBy('tarikh', 'desc')
                    ->get();
            }
        }

        return view('pentadbir.maklumatIbuBapa', compact('parents', 'selectedParent', 'feedbacks'));
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
                        $prestasi = Prestasi::where('murid_id', $muridId)
                            ->where('subjek', $selectedSubjek)
                            ->get()
                            ->keyBy(function ($item) {
                                return $item->kriteria_nama . '_' . $item->penggal;
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
        try {
            $request->validate([
                'murid_id' => 'required|exists:murid,MyKidID',
                'subject_id' => 'required|exists:subjek,id',
                'penggal' => 'required|in:1,2',
                'assessments' => 'required|array',
            ], [
                'murid_id.required' => 'ID Murid diperlukan',
                'murid_id.exists' => 'ID Murid tidak sah',
                'subject_id.required' => 'ID Subjek diperlukan',
                'subject_id.exists' => 'ID Subjek tidak sah',
                'penggal.required' => 'Penggal diperlukan',
                'penggal.in' => 'Penggal mestilah 1 atau 2',
                'assessments.required' => 'Sekurang-kurangnya satu penilaian diperlukan',
                'assessments.array' => 'Data penilaian tidak sah',
            ]);

            $muridId = $request->murid_id;
            $subjectId = $request->subject_id;
            $penggal = $request->penggal;

            // Get subject name for logging/debugging
            $subject = Subjek::find($subjectId);
            $subjectName = $subject ? $subject->nama_subjek : 'Unknown';

            // Get admin ID from session
            $adminId = session('user') ? session('user')->ID_Admin : null;

            $successCount = 0;
            $skipCount = 0;

            foreach ($request->assessments as $kriteria => $tahapPencapaian) {
                // Skip empty assessments
                if (empty($tahapPencapaian)) {
                    $skipCount++;
                    continue;
                }

                // Convert text values to numeric values for markah
                $markah = $tahapPencapaian;
                if ($tahapPencapaian === 'AM') {
                    $markah = 1;
                } elseif ($tahapPencapaian === 'M') {
                    $markah = 2;
                } elseif ($tahapPencapaian === 'SM') {
                    $markah = 3;
                }

                try {
                    $result = Prestasi::updateOrCreate(
                        [
                            'murid_id' => $muridId,
                            'subject_id' => $subjectId,
                            'kriteria_nama' => $kriteria,
                            'penggal' => $penggal,
                        ],
                        [
                            'admin_id' => $adminId,
                            'subjek' => $subjectName,
                            'tahap_pencapaian' => $tahapPencapaian,
                            'markah' => $markah,
                            'tarikhRekod' => now(),
                        ]
                    );

                    if ($result) {
                        $successCount++;
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to save individual assessment', [
                        'murid_id' => $muridId,
                        'subject_id' => $subjectId,
                        'kriteria' => $kriteria,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Penilaian prestasi berjaya disimpan.',
                    'data' => [
                        'success_count' => $successCount,
                        'skip_count' => $skipCount,
                        'total_processed' => count($request->assessments)
                    ]
                ]);
            }

            if ($successCount > 0) {
                return redirect()->back()->with('success', 'Data berjaya disimpan');
            } else {
                return redirect()->back()->with('warning', 'Tiada penilaian yang disimpan. Semua medan penilaian kosong.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Prestasi save error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input' => $request->all()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berlaku ralat ketika menyimpan penilaian.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Berlaku ralat ketika menyimpan penilaian.')
                ->withInput();
        }
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

    public function laporan(Request $request)
    {
        try {
            // Start building the query
            $query = Prestasi::with(['murid', 'subject', 'guru']);

            // Search filter by name or mykid id
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->whereHas('murid', function ($subQuery) use ($search) {
                        $subQuery->where('namaMurid', 'like', '%' . $search . '%')
                                 ->orWhere('MyKidID', 'like', '%' . $search . '%');
                    });
                });
            }

            // Filter by kelas
            if ($request->filled('kelas')) {
                $query->whereHas('murid', function ($q) {
                    $q->where('kelas', $request->input('kelas'));
                });
            }

            // Filter by subjek
            if ($request->filled('subjek')) {
                $query->where('subjek', $request->input('subjek'));
            }

            // Filter by penggal
            if ($request->filled('penggal')) {
                $query->where('penggal', $request->input('penggal'));
            }

            // Filter by tarikh rekod (date range)
            if ($request->filled('tarikh_dari')) {
                $query->whereDate('tarikhRekod', '>=', $request->input('tarikh_dari'));
            }
            if ($request->filled('tarikh_hingga')) {
                $query->whereDate('tarikhRekod', '<=', $request->input('tarikh_hingga'));
            }

            // Order by date
            $prestasi = $query->orderBy('tarikhRekod', 'desc')->get();

            // Get all unique values for dropdown filters
            $allPrestasi = Prestasi::with(['murid', 'subject', 'guru'])->get();
            $kelasList = Murid::distinct('kelas')->pluck('kelas')->sort();
            $subjectList = Prestasi::distinct('subjek')->pluck('subjek')->sort();
            $penggalList = Prestasi::distinct('penggal')->pluck('penggal')->sort();

            // Group prestasi by student for better organization
            $prestasiByStudent = $prestasi->groupBy('murid_id');

            // Get summary statistics
            $totalRecords = $prestasi->count();
            $uniqueStudents = $prestasi->pluck('murid_id')->unique()->count();
            $subjects = $prestasi->pluck('subjek')->unique();

            // Get list of student IDs from filtered prestasi
            $studentIds = $prestasi->pluck('murid_id')->unique();

            // Build query for Kehadiran data based on filtered students
            $kehadiranQuery = Kehadiran::with(['murid', 'guru']);
            
            // Filter by student IDs from prestasi results
            if ($studentIds->isNotEmpty()) {
                $kehadiranQuery->whereIn('MyKidID', $studentIds);
            } else {
                // If no prestasi results, still allow filtering by search/kelas for kehadiran
                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $kehadiranQuery->whereHas('murid', function ($q) use ($search) {
                        $q->where('namaMurid', 'like', '%' . $search . '%')
                          ->orWhere('MyKidID', 'like', '%' . $search . '%');
                    });
                }
                if ($request->filled('kelas')) {
                    $kehadiranQuery->whereHas('murid', function ($q) use ($request) {
                        $q->where('kelas', $request->input('kelas'));
                    });
                }
            }

            // Apply Kehadiran date filters
            if ($request->filled('kehadiran_tarikh_dari')) {
                $kehadiranQuery->whereDate('tarikh', '>=', $request->input('kehadiran_tarikh_dari'));
            }
            if ($request->filled('kehadiran_tarikh_hingga')) {
                $kehadiranQuery->whereDate('tarikh', '<=', $request->input('kehadiran_tarikh_hingga'));
            }

            $kehadiran = $kehadiranQuery->orderBy('tarikh', 'desc')->get();

            // Calculate Kehadiran statistics
            $totalDays = $kehadiran->count();
            $presentDays = $kehadiran->where('status', 'hadir')->count();
            $absentDays = $kehadiran->where('status', 'tidak_hadir')->count();
            $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        } catch (\Throwable $e) {
            $prestasi = collect();
            $prestasiByStudent = collect();
            $totalRecords = 0;
            $uniqueStudents = 0;
            $subjects = collect();
            $kelasList = collect();
            $subjectList = collect();
            $penggalList = collect();
            $kehadiran = collect();
            $totalDays = 0;
            $presentDays = 0;
            $absentDays = 0;
            $attendancePercentage = 0;
        }

        return view('pentadbir.laporan', compact('prestasi', 'prestasiByStudent', 'totalRecords', 'uniqueStudents', 'subjects', 'kelasList', 'subjectList', 'penggalList', 'kehadiran', 'totalDays', 'presentDays', 'absentDays', 'attendancePercentage'));
    }
}
