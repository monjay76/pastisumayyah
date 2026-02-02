<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Murid;
use App\Models\Subjek;
use Illuminate\Http\Request;

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
                                    return ($item->kriteria_nama ?? '') . '_' . $item->penggal;
                                });
                    } catch (\Throwable $e) {
                        $prestasi = collect();
                    }
                    $ayatList = $this->getAyatList($selectedSubjek);
                }
            }
        }

        return view('guru.prestasiMurid', compact('classes', 'selectedClass', 'students', 'selectedStudent', 'subjekList', 'selectedSubjek', 'ayatList', 'prestasi'));
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

    /**
     * Store prestasi assessment
     */
    public function store(Request $request)
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
                    'murid_id' => $myKidID,
                    'subjek' => $subjek,
                    'kriteria_nama' => $ayat,
                    'penggal' => $penggal,
                ],
                [
                    'guru_id' => auth()->user()->ID_Guru ?? 1,
                    'tahap_pencapaian' => $tahapPencapaian,
                    'tarikhRekod' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Penilaian prestasi berjaya disimpan.');
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
