<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\IbuBapa;
use App\Models\Kehadiran;
use App\Models\Prestasi;
use App\Models\Laporan;
use App\Models\Aktiviti;
use Illuminate\Support\Facades\Storage;

class GuruPageController extends Controller
{
    public function senaraiMurid(Request $request)
    {
        // Attempt to load murid list; if DB not available, return empty collection
        try {
            $query = Murid::orderBy('namaMurid');

            // Filter by kelas if provided
            if ($request->filled('kelas')) {
                $query->where('kelas', $request->input('kelas'));
            }

            $murid = $query->get();
            $kelasList = Murid::distinct('kelas')->pluck('kelas')->sort();
        } catch (\Throwable $e) {
            $murid = collect();
            $kelasList = collect();
        }

        return view('guru.senaraiMurid', compact('murid', 'kelasList'));
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

    public function updateProfilePicture(Request $request, $id)
    {
        $request->validate([
            'gambar_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $murid = Murid::findOrFail($id);

        // Delete old image if exists
        if ($murid->gambar_profil && Storage::disk('public')->exists($murid->gambar_profil)) {
            Storage::disk('public')->delete($murid->gambar_profil);
        }

        // Store new image
        $path = $request->file('gambar_profil')->store('gambar_profil', 'public');

        // Update database
        $murid->update(['gambar_profil' => $path]);

        return redirect()->back()->with('success', 'Gambar profil berjaya dikemas kini.');
    }

    public function senaraiKehadiran(Request $request)
    {
        try {
            $classes = Murid::distinct()->pluck('kelas')->filter()->sort();
        } catch (\Throwable $e) {
            $classes = collect();
        }
        $kelas = $request->query('kelas');
        $tarikh = $request->query('tarikh');

        if ($kelas && $tarikh) {
            try {
                $murid = Murid::where('kelas', $kelas)->orderBy('namaMurid')->get();
                $kehadiran = Kehadiran::where('tarikh', $tarikh)
                    ->whereIn('MyKidID', $murid->pluck('MyKidID'))
                    ->get()
                    ->keyBy('MyKidID');
            } catch (\Throwable $e) {
                $murid = collect();
                $kehadiran = collect();
            }

            return view('guru.senaraiKehadiran', compact('classes', 'kelas', 'tarikh', 'murid', 'kehadiran'));
        }

        return view('guru.senaraiKehadiran', compact('classes'));
    }

    public function aktivitiTahunan()
    {
        // No dedicated Aktiviti model available; return an empty collection
        // so the view can render safely. If you add an Aktiviti model later,
        // replace this with a DB query similar to the other methods.
        $aktiviti = collect();
        return view('guru.aktivitiTahunan', compact('aktiviti'));
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
            $images = Aktiviti::where('month', $month)->orderBy('tarikh', 'desc')->get();
        } catch (\Throwable $e) {
            $images = collect();
        }

        return view('guru.aktivitiTahunanMonth', compact('month', 'monthName', 'images'));
    }

    public function storeAktivitiImage(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'tarikh' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Store the image in storage/app/public/aktiviti
            $path = $request->file('image')->store('aktiviti', 'public');

            // Create record in database
            Aktiviti::create([
                'month' => $request->month,
                'tarikh' => $request->tarikh,
                'path' => $path,
            ]);

            return redirect()->back()->with('success', 'Gambar berjaya ditambah.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menambah gambar. Sila cuba lagi.');
        }
    }

    public function deleteAktivitiImage($id)
    {
        try {
            $aktiviti = Aktiviti::findOrFail($id);

            // Delete the file from storage
            Storage::disk('public')->delete($aktiviti->path);

            // Delete from database
            $aktiviti->delete();

            return redirect()->back()->with('success', 'Gambar berjaya dipadam.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal memadam gambar. Sila cuba lagi.');
        }
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

        } catch (\Throwable $e) {
            $prestasi = collect();
            $prestasiByStudent = collect();
            $totalRecords = 0;
            $uniqueStudents = 0;
            $subjects = collect();
            $kelasList = collect();
            $subjectList = collect();
            $penggalList = collect();
        }

        return view('guru.laporan', compact('prestasi', 'prestasiByStudent', 'totalRecords', 'uniqueStudents', 'subjects', 'kelasList', 'subjectList', 'penggalList'));
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
        $listIbuBapa = IbuBapa::orderBy('namaParent')->get();
        return view('guru.addMurid', compact('listIbuBapa'));
    }

    public function storeMurid(Request $request)
    {
        $request->validate([
            'MyKidID' => 'required|string|unique:murid,MyKidID',
            'namaMurid' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
            'tarikhLahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'parent_id' => 'required|exists:ibubapa,ID_Parent',
        ]);

        // Create the student record
        $murid = Murid::create([
            'MyKidID' => $request->MyKidID,
            'namaMurid' => $request->namaMurid,
            'kelas' => $request->kelas,
            'tarikhLahir' => $request->tarikhLahir,
            'alamat' => $request->alamat,
        ]);

        // Attach parent relationships if any parents are selected
        if ($request->filled('parent_id')) {
            $murid->ibubapa()->attach($request->parent_id);
        }

        return redirect()->route('guru.senaraiMurid')->with('success', 'Murid dan penjaga berjaya didaftarkan.');
    }

    public function storeKehadiran(Request $request)
    {
        $kelas = $request->input('kelas');
        $tarikh = $request->input('tarikh');
        $statuses = $request->input('status', []);

        foreach ($statuses as $myKidID => $status) {
            Kehadiran::updateOrCreate(
                ['MyKidID' => $myKidID, 'tarikh' => $tarikh],
                ['status' => $status, 'direkodOleh' => auth()->id()] // Assuming auth()->id() is the guru ID
            );
        }

        return redirect()->route('guru.senaraiKehadiran', ['kelas' => $kelas, 'tarikh' => $tarikh])->with('success', 'Kehadiran berjaya disimpan.');
    }

    public function editKehadiran(Request $request)
    {
        $kelas = $request->query('kelas');
        $tarikh = $request->query('tarikh');

        if (!$kelas || !$tarikh) {
            return redirect()->route('guru.senaraiKehadiran')->with('error', 'Kelas dan tarikh diperlukan.');
        }

        try {
            $murid = Murid::where('kelas', $kelas)->orderBy('namaMurid')->get();
            $kehadiran = Kehadiran::where('tarikh', $tarikh)
                ->whereIn('MyKidID', $murid->pluck('MyKidID'))
                ->get()
                ->keyBy('MyKidID');
        } catch (\Throwable $e) {
            $murid = collect();
            $kehadiran = collect();
        }

        return view('guru.editKehadiran', compact('kelas', 'tarikh', 'murid', 'kehadiran'));
    }
}
