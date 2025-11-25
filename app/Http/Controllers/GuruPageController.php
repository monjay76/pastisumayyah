<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Kehadiran;
use App\Models\Prestasi;
use App\Models\Laporan;

class GuruPageController extends Controller
{
    public function senaraiMurid()
    {
        // Attempt to load murid list; if DB not available, return empty collection
        try {
            $murid = Murid::orderBy('namaMurid')->get();
        } catch (\Throwable $e) {
            $murid = collect();
        }

        return view('guru.senaraiMurid', compact('murid'));
    }

    /**
     * Show single murid profile. Accepts an id and returns the profile view.
     * If DB is unavailable or the record doesn't exist, the view receives null.
     */
    public function profilMurid(Request $request)
    {
        $classes = Murid::distinct()->pluck('kelas')->filter()->sort();
        $selectedClass = $request->query('kelas');
        $selectedStudent = null;
        $students = collect();

        if ($selectedClass) {
            $students = Murid::where('kelas', $selectedClass)->get();
            $muridId = $request->query('murid');
            if ($muridId) {
                $selectedStudent = Murid::find($muridId);
            }
        }

        return view('guru.profilMurid', compact('classes', 'selectedClass', 'students', 'selectedStudent'));
    }

    public function senaraiKehadiran()
    {
        try {
            $kehadiran = Kehadiran::with('murid')->orderBy('tarikh', 'desc')->get();
        } catch (\Throwable $e) {
            $kehadiran = collect();
        }

        return view('guru.senaraiKehadiran', compact('kehadiran'));
    }

    public function aktivitiTahunan()
    {
        // No dedicated Aktiviti model available; return an empty collection
        // so the view can render safely. If you add an Aktiviti model later,
        // replace this with a DB query similar to the other methods.
        $aktiviti = collect();
        return view('guru.aktivitiTahunan', compact('aktiviti'));
    }

    public function prestasiMurid()
    {
        try {
            $prestasi = Prestasi::with('murid')->orderBy('created_at', 'desc')->get();
        } catch (\Throwable $e) {
            $prestasi = collect();
        }

        return view('guru.prestasiMurid', compact('prestasi'));
    }

    public function laporan()
    {
        try {
            $laporan = Laporan::with('murid')->orderBy('tarikh', 'desc')->get();
        } catch (\Throwable $e) {
            $laporan = collect();
        }

        return view('guru.laporan', compact('laporan'));
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $selected = $request->input('selected_murid', []);

        if (empty($selected)) {
            return redirect()->back()->with('error', 'Tiada murid dipilih.');
        }

        if ($action == 'delete') {
            Murid::whereIn('MyKidID', $selected)->delete();
            return redirect()->back()->with('success', 'Murid terpilih telah dipadam.');
        } elseif ($action == 'edit') {
            if (count($selected) == 1) {
                return redirect()->route('guru.murid.edit', $selected[0]);
            } else {
                return redirect()->back()->with('error', 'Pilih hanya satu murid untuk edit.');
            }
        }

        return redirect()->back();
    }

    public function addMurid()
    {
        return view('guru.addMurid');
    }

    public function storeMurid(Request $request)
    {
        $request->validate([
            'MyKidID' => 'required|string|unique:murid,MyKidID',
            'namaMurid' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'tarikhLahir' => 'nullable|date',
            'alamat' => 'nullable|string',
        ]);

        Murid::create($request->all());

        return redirect()->route('guru.senaraiMurid')->with('success', 'Murid berjaya ditambah.');
    }
}
