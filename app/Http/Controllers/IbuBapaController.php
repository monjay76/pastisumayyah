<?php

namespace App\Http\Controllers;

use App\Models\IbuBapa;
use App\Models\Laporan;
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
        $feedbacks = Feedback::all();
        return view('ibubapa.maklumbalas', compact('feedbacks'));
    }

    public function storeMaklumBalas(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:Guru,Aktiviti,Sekolah,Lain-lain',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Feedback::create([
            'kandungan' => json_encode([
                'subject' => $request->subject,
                'category' => $request->category,
                'message' => $request->message,
                'rating' => $request->rating,
            ]),
            'tarikh' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Maklum balas berjaya dihantar.');
    }
}
