<?php

namespace App\Http\Controllers;

use App\Models\IbuBapa;
use App\Models\Laporan;
use App\Models\Feedback;
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
}
