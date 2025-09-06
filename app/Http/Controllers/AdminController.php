<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    public function loginForm() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // gunakan cek role_id (misal admin memiliki id 1)
            if ((int) $user->role_id === 1) {
                return redirect()->route('admin.dashboard'); // Dashboard admin
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized. Admin only.']);
            }
        }

        return back()->withErrors(['email'=>'Invalid admin credentials']);
    }

    // Ditambahkan: method index untuk route /admin/dashboard
    public function index() {
        return view('admin.dashboard');
    }
}