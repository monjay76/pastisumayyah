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
        try {
            $validated = $request->validate([
                'murid_id' => 'required|exists:murid,MyKidID',
                'subject_id' => 'required|exists:subjek,id',
                'penggal' => 'required|in:1,2',
                'assessments' => 'required|array',
            ], [
                'murid_id.required' => 'ID Murid diperlukan',
                'murid_id.exists' => 'ID Murid tidak sah',
                'subject_id.required' => 'ID Subjek diperlukan',
                'subject_id.exists' => 'ID Subjek tidak sah atau tidak wujud dalam sistem',
                'penggal.required' => 'Penggal diperlukan',
                'penggal.in' => 'Penggal mestilah 1 atau 2',
                'assessments.required' => 'Sekurang-kurangnya satu penilaian diperlukan',
                'assessments.array' => 'Data penilaian tidak sah',
            ]);

            $muridId = $validated['murid_id'];
            $subjectId = $validated['subject_id'];
            $penggal = $validated['penggal'];

            // Get user from session (since LoginController uses session-based auth)
            $user = session('user');
            if (!$user) {
                \Log::error('Authentication error: User session not found', [
                    'request_input' => $request->all()
                ]);
                return redirect()->back()
                    ->with('error', 'Sesi pengguna tidak sah. Sila log keluar dan log masuk semula.')
                    ->withInput();
            }

            // For administrators (Pentadbir), set guru_id to null
            $guruId = null;

            // Get subject name for logging/debugging
            $subject = Subjek::find($subjectId);
            $subjectName = $subject ? $subject->nama_subjek : 'Unknown';

            // Log the assessment data for debugging
            \Log::info('Saving prestasi assessment (Pentadbir)', [
                'murid_id' => $muridId,
                'subject_id' => $subjectId,
                'subject_name' => $subjectName,
                'penggal' => $penggal,
                'guru_id' => $guruId,
                'assessment_count' => count($validated['assessments'])
            ]);

            $successCount = 0;
            $skipCount = 0;

            foreach ($validated['assessments'] as $kriteria => $tahapPencapaian) {
                // Skip empty assessments
                if (empty($tahapPencapaian)) {
                    $skipCount++;
                    continue;
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
                            'guru_id' => $guruId,
                            'subjek' => $subjectName,
                            'tahap_pencapaian' => $tahapPencapaian,
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

            // Log summary
            \Log::info('Prestasi assessment completed (Pentadbir)', [
                'success_count' => $successCount,
                'skip_count' => $skipCount,
                'total_attempted' => count($validated['assessments'])
            ]);

            if ($successCount > 0) {
                return redirect()->back()->with('success', 'Data berjaya masukkan');
            } else {
                return redirect()->back()->with('warning', 'Tiada penilaian yang disimpan. Semua medan penilaian kosong.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Prestasi validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            // Build more specific error message based on validation errors
            $errorMessages = $e->errors();
            $customMessage = 'Gagal menyimpan penilaian: ';

            if (isset($errorMessages['subject_id'])) {
                $customMessage .= 'ID Subjek tidak sah. ';
                if (strpos($errorMessages['subject_id'][0], 'exists') !== false) {
                    $customMessage .= 'Subjek yang dipilih mungkin tidak wujud dalam sistem atau ID subjek tidak dapat dijumpai. ';
                    $customMessage .= 'Sila muat semula halaman atau pilih subjek semula.';
                }
            } elseif (isset($errorMessages['murid_id'])) {
                $customMessage .= 'ID Murid tidak sah. ';
            } elseif (isset($errorMessages['penggal'])) {
                $customMessage .= 'Penggal tidak sah. ';
            } else {
                $customMessage .= $e->getMessage();
            }

            return redirect()->back()
                ->with('error', $customMessage)
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Prestasi save error: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input' => $request->all()
            ]);

            // Provide more specific error messages for common issues
            $errorMessage = 'Berlaku ralat ketika menyimpan penilaian. ';

            if (strpos($e->getMessage(), 'subject_id') !== false ||
                strpos($e->getMessage(), 'subjek') !== false) {
                $errorMessage .= 'Masalah dengan ID Subjek. ';
            }

            $errorMessage .= 'Sila cuba semula atau hubungi pentadbir jika masalah berterusan.';

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
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
