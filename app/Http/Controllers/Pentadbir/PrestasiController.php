<?php

namespace App\Http\Controllers\Pentadbir;

use App\Models\Prestasi;
use App\Models\Murid;
use App\Models\Subjek;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrestasiController extends Controller
{
    /**
     * Show the main prestasi page with class selection
     */
    public function index(Request $request)
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

        return view('pentadbir.prestasiMurid', compact('classes', 'selectedClass', 'students', 'selectedStudent', 'subjekList', 'selectedSubjek', 'ayatList', 'prestasi'));
    }

    /**
     * Get performance data via AJAX
     */
    public function getPerformance(Request $request)
    {
        $request->validate([
            'murid_id' => 'required|exists:murid,MyKidID',
            'subject_id' => 'required|exists:subjek,id',
            'penggal' => 'required|in:1,2'
        ]);

        $muridId = $request->murid_id;
        $subjectId = $request->subject_id;
        $penggal = $request->penggal;

        $prestasi = Prestasi::where('murid_id', $muridId)
            ->where('subject_id', $subjectId)
            ->where('penggal', $penggal)
            ->get()
            ->keyBy('kriteria_nama');

        return response()->json([
            'success' => true,
            'data' => $prestasi
        ]);
    }

    /**
     * Store or update performance assessment
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'murid_id' => 'required|exists:murid,MyKidID',
            'subject_id' => 'required|exists:subjek,id',
            'penggal' => 'required|in:1,2',
            'assessments' => 'required|array',
        ]);

        $muridId = $request->murid_id;
        $subjectId = $request->subject_id;
        $penggal = $request->penggal;
        $guruId = auth()->user()->ID_Guru ?? 1;

        foreach ($request->assessments as $kriteria => $tahapPencapaian) {
            Prestasi::updateOrCreate(
                [
                    'murid_id' => $muridId,
                    'subject_id' => $subjectId,
                    'kriteria_nama' => $kriteria,
                    'penggal' => $penggal,
                ],
                [
                    'guru_id' => $guruId,
                    'subjek' => Subjek::find($subjectId)->nama_subjek,
                    'tahap_pencapaian' => $tahapPencapaian,
                    'tarikhRekod' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Penilaian prestasi berjaya disimpan.');
    }

    /**
     * Get ayat list based on subject
     */
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

        // For Nurul Quran
        if ($subjekLower == 'nurul quran') {
            return [
                'Buku 1 - Unit 1 : Mukasurat 1 - 29',
                'Buku 1 - Unit 1 : Mukasurat 29 - 40',
                'Buku 1 - Unit 2 : Mukasurat 42 - 53',
                'Buku 1 - Unit 2 : Mukasurat 54 - 64'
            ];
        }

        // For general subjects
        if (in_array($subjekLower, [
            'bahasa malaysia', 'bahasa inggeris', 'matematik',
            'sains', 'jawi', 'peribadi muslim', 'arab'
        ])) {
            return [
                'Pengecaman & Kenal Huruf/Nombor',
                'Sebutan & Bunyi',
                'Kemahiran Membaca',
                'Kemahiran Menulis',
                'Kefahaman & Aplikasi'
            ];
        }

        // Default: return numbered ayat
        return range(1, 15);
    }
}
