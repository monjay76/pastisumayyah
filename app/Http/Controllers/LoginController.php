<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pentadbir;
use App\Models\Guru;
use App\Models\IbuBapa;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->username;
        $password = $request->password;

        $user = null;
        $role = null;

        // Check in pentadbir table
        $user = Pentadbir::where('ID_Admin', $username)->first();
        if ($user) {
            $role = 'pentadbir';
        } else {
            // Check in guru table
            $user = Guru::where('ID_Guru', $username)->first();
            if ($user) {
                $role = 'guru';
            } else {
                // Check in ibubapa table
                $user = IbuBapa::where('ID_Parent', $username)->first();
                if ($user) {
                    $role = 'ibubapa';
                }
            }
        }

        // If user not found, username is incorrect
        if (!$user) {
            return back()->withErrors(['login' => 'Salah Username']);
        }

        // If user found but password is incorrect
        if (!\Hash::check($password, $user->kataLaluan)) {
            return back()->withErrors(['login' => 'Salah Password']);
        }

        // Credentials are correct, proceed with login
        session(['user' => $user, 'role' => $role]);

        // Redirect based on role
        switch ($role) {
            case 'pentadbir':
                return redirect()->route('pentadbir.index');
            case 'guru':
                return redirect()->route('guru.index');
            case 'ibubapa':
                return redirect()->route('ibubapa.profilMurid');
        }
    }

    public function logout(Request $request)
    {
        // Clear the session
        session()->flush();

        // Redirect to login page
        return redirect()->route('login');
    }
}
