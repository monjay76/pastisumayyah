<?php

namespace App\Http\Controllers;

use App\Models\IbuBapa;
use App\Models\Laporan;
use App\Models\Feedback;
use App\Models\Prestasi;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class IbuBapaController extends Controller
{
    public function index()
    {
        return response()->json(IbuBapa::all());
    }

    public function store(Request $request)
    {
        $ibubapa = IbuBapa::create($request->all());
        return response()->json(['message' => 'Ibu bapa berjaya didaftarkan', 'data' => $ibubapa]);
    }

    public function show($id)
    {
        return response()->json(IbuBapa::with('murid')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $ibubapa = IbuBapa::findOrFail($id);
        $ibubapa->update($request->all());
        return response()->json(['message' => 'Maklumat ibu bapa dikemas kini']);
    }

    public function destroy($id)
    {
        IbuBapa::destroy($id);
        return response()->json(['message' => 'Rekod ibu bapa dipadam']);
    }

    public function maklumBalas()
    {
        $feedbacks = Feedback::orderBy('tarikh', 'desc')->get();
        return view('ibubapa.maklumbalas', compact('feedbacks'));
    }

    public function storeMaklumBalas(Request $request)
    {
        $request->validate([
            'category' => 'required|in:Pujian,Cadangan,Pertanyaan Perkembangan Murid,Lain-lain',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Feedback::create([
            'kandungan' => json_encode([
                'category' => $request->category,
                'message' => $request->message,
                'rating' => $request->rating,
            ]),
            'tarikh' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Maklum balas anda telah dihantar. Terima kasih atas maklum balas berharga anda!');
    }

    public function aktivitiTahunan()
    {
        return view('ibubapa.aktivitiTahunan');
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
        return view('ibubapa.aktivitiTahunan', compact('month', 'monthName', 'images', 'selectedMonth'));
    }

    /**
     * Display the profile of children for the logged-in parent
     */
    public function profilMurid()
    {
        // Get the logged-in parent from session
        $parent = session('user');

        if (!$parent) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        // Fetch all children associated with this parent
        $children = $parent->murid()->with('kehadiran', 'prestasi', 'laporan')->get();

        return view('ibubapa.profilMurid', [
            'parent' => $parent,
            'children' => $children
        ]);
    }

    /**
     * Display laporan (reports) for parent's children
     * Shows both Prestasi (performance) and Kehadiran (attendance) data
     */
    public function laporan(Request $request)
    {
        $parent = session('user');
        if (!$parent) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        // Get all children for dropdown
        $children = $parent->murid()->select('murid.MyKidID', 'murid.namaMurid')->get();
        
        $selectedChild = null;
        $prestasi = collect();
        $prestasiBySubject = collect();
        $totalRecords = 0;
        $avgMarkah = 0;
        $subjects = collect();
        $subjectList = collect();
        $penggalList = collect();
        
        // Kehadiran data
        $kehadiran = collect();
        $totalDays = 0;
        $presentDays = 0;
        $absentDays = 0;
        $attendancePercentage = 0;

        // If a child is selected
        if ($request->filled('mykid')) {
            $myKidId = $request->input('mykid');
            
            // Verify child belongs to parent
            $selectedChild = $parent->murid()->where('murid.MyKidID', $myKidId)->first();
            
            if ($selectedChild) {
                // Build query for Prestasi data
                $query = Prestasi::with(['murid', 'subject', 'guru'])
                    ->where('murid_id', $myKidId);

                // Apply Prestasi filters
                if ($request->filled('subjek')) {
                    $query->where('subjek', $request->input('subjek'));
                }
                if ($request->filled('penggal')) {
                    $query->where('penggal', $request->input('penggal'));
                }
                if ($request->filled('tarikh_dari')) {
                    $query->whereDate('tarikhRekod', '>=', $request->input('tarikh_dari'));
                }
                if ($request->filled('tarikh_hingga')) {
                    $query->whereDate('tarikhRekod', '<=', $request->input('tarikh_hingga'));
                }

                $prestasi = $query->orderBy('tarikhRekod', 'desc')->get();
                
                // Calculate Prestasi statistics
                $totalRecords = $prestasi->count();
                $avgMarkah = $prestasi->avg('markah') ?: 0;
                $subjects = $prestasi->pluck('subjek')->unique();
                $prestasiBySubject = $prestasi->groupBy('subjek');
                
                // Get filter options for Prestasi
                $allPrestasi = Prestasi::where('murid_id', $myKidId)->get();
                $subjectList = $allPrestasi->pluck('subjek')->unique()->sort();
                $penggalList = $allPrestasi->pluck('penggal')->unique()->sort()->filter();
                
                // Build query for Kehadiran data
                $kehadiranQuery = Kehadiran::with('guru')
                    ->where('MyKidID', $myKidId);
                
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
            }
        }

        return view('ibubapa.laporan', compact(
            'children', 'selectedChild', 'prestasi', 'prestasiBySubject',
            'totalRecords', 'avgMarkah', 'subjects', 'subjectList', 'penggalList',
            'kehadiran', 'totalDays', 'presentDays', 'absentDays', 'attendancePercentage'
        ));
    }
}
