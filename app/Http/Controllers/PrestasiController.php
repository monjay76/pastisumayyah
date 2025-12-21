<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Murid;
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
        $selectedSubjek = null;
        $students = collect();
        $subjekList = ['Surah Al-Mulk', 'Surah Al-Kahf', 'Surah Yasin', 'Surah Ar-Rahman'];
        $ayatList = [];
        $prestasi = collect();

        // If class is selected, get students
        if ($selectedClass) {
            $students = Murid::where('kelas', $selectedClass)->orderBy('namaMurid')->get();
            
            // If student is selected
            $muridId = $request->query('murid');
            if ($muridId) {
                $selectedStudent = Murid::find($muridId);
                
                // If subject is selected
                $selectedSubjek = $request->query('subjek');
                if ($selectedSubjek) {
                    // Generate ayat list based on subject
                    $ayatList = $this->getAyatList($selectedSubjek);
                    
                    // Get existing prestasi for this student and subject
                    $prestasi = Prestasi::where('MyKidID', $muridId)
                        ->where('subjek', $selectedSubjek)
                        ->get()
                        ->groupBy(function($item) {
                            return $item->ayat . '_' . $item->penggal;
                        });
                }
            }
        }

        return view('guru.prestasiMurid', compact(
            'classes', 
            'selectedClass', 
            'students', 
            'selectedStudent',
            'subjekList',
            'selectedSubjek',
            'ayatList',
            'prestasi'
        ));
    }

    /**
     * Get ayat list based on subject
     */
    private function getAyatList($subjek)
    {
        $ayatLists = [
            'Surah Al-Mulk' => range(1, 30),
            'Surah Al-Kahf' => range(1, 110),
            'Surah Yasin' => range(1, 83),
            'Surah Ar-Rahman' => range(1, 78),
        ];

        // For demo purposes, limit to first 15 ayat
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

        try {
            $myKidID = $request->MyKidID;
            $subjek = $request->subjek;
            $penggal = $request->penggal;
            $assessments = $request->assessments;

            foreach ($assessments as $ayat => $tahapPencapaian) {
                if ($tahapPencapaian) {
                    Prestasi::updateOrCreate(
                        [
                            'MyKidID' => $myKidID,
                            'subjek' => $subjek,
                            'ayat' => $ayat,
                            'penggal' => $penggal,
                        ],
                        [
                            'ID_Guru' => auth()->user()->ID_Guru ?? 1, // Assuming logged in guru
                            'tahapPencapaian' => $tahapPencapaian,
                            'tarikhRekod' => now(),
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', 'Penilaian prestasi berjaya disimpan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan penilaian. Sila cuba lagi.');
        }
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
