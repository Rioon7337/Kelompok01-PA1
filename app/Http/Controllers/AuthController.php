<?php

namespace App\Http\Controllers;

use App\Models\Admin;  // Ganti User dengan Admin
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim link reset password ke EMAIL
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admin,email'  // Ganti users dengan admin
        ]);

        $admin = Admin::where('email', $request->email)->first();  // Ganti User dengan Admin
        
        if (!$admin) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token
        $token = Str::random(64);
        
        // Hapus token lama jika ada
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        // Simpan token baru
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        // Kirim email
        try {
            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
            
            return back()->with('success', 'Link reset password telah dikirim ke ' . $request->email . '. Silahkan cek inbox atau folder spam Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    // Tampilkan form reset password
    public function showResetForm($token)
    {
        $resetData = DB::table('password_resets')
            ->where('token', $token)
            ->first();
        
        if (!$resetData) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Token reset password tidak valid. Silahkan request ulang.']);
        }
        
        $createdAt = Carbon::parse($resetData->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 60) {
            DB::table('password_resets')->where('token', $token)->delete();
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Link reset password sudah kadaluarsa. Silahkan request ulang.']);
        }
        
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $resetData->email
        ]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admin',  // Ganti users dengan admin
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);
        
        $resetData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        
        if (!$resetData) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }
        
        $createdAt = Carbon::parse($resetData->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 60) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Link reset password sudah kadaluarsa. Silahkan request ulang.']);
        }
        
        Admin::where('email', $request->email)->update([  // Ganti User dengan Admin
            'password' => Hash::make($request->password)
        ]);
        
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silahkan login dengan password baru Anda.');
    }
}