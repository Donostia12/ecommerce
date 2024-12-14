<?php

namespace App\Http\Controllers;

use App\Mail\HaloMail;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'Username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek status akun
            if ($user->role == 1) {
                return redirect()->route('admin');
            }
            if ($user->status == 2) {
                // Validasi email sebelum mengirim
                if (!empty($user->Email) && filter_var($user->Email, FILTER_VALIDATE_EMAIL)) {
                    $verificationLink = route('verify.user', ['id' => $user->id]);
                    Mail::to($user->Email)->send(new HaloMail($verificationLink));
                } else {
                    Auth::logout(); // Logout user karena belum diverifikasi
                    return back()->withErrors(['loginError' => 'Email pengguna tidak valid atau kosong.']);
                }

                Auth::logout(); // Logout user karena belum diverifikasi
                return back()->withErrors(['loginError' => 'Akun Anda belum diverifikasi. Email verifikasi telah dikirim.']);
            }

            return redirect()->route('index')->with('success', 'Login berhasil.');
        }

        return back()->withErrors(['loginError' => 'Username atau password tidak sesuai.']);
    }




    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate the registration form data
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'password2' => 'required' // The 'confirmed' rule ensures password and confirm_password match
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username Harus di isi',
            'username.unique' => 'Username ini sudah digunakan. Pilih username lain.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email Sudah Pernah di daftarkan , pilih email lain',
            'password.required' => 'password harus di isi',
            'password2.required' => 'Password Konfirmasi harus di isi'
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2, // Default belum diverifikasi
            'status' => 2
        ]);

        // Kirim email verifikasi
        $verificationLink = route('verify.user', ['id' => $user->id]);
        Mail::to($user->email)->send(new HaloMail($verificationLink));

        return redirect()->route('index')->with('success', 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi.');
    }


    public function logout(Request $request)
    {
        // Logout the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect()->route('index')->with('success', 'Anda telah berhasil logout.');
    }
    public function verify($id)
    {
        $user = User::find($id);

        if (!$user || $user->status != 2) {
            return redirect()->route('index')->withErrors(['error' => 'Link verifikasi tidak valid.']);
        }

        // Ubah status akun menjadi terverifikasi
        $user->status = 1;
        $user->save();

        return redirect()->route('index')->with('success', 'Akun Anda telah berhasil diverifikasi. Silakan login.');
    }
}
