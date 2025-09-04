<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    public function loginForm() { return view('admin.login'); }

    public function login(Request $request) {
        if(Auth::guard('admin')->attempt($request->only('email','password'))){
            return redirect('/admin/destinations');
        }
        return back()->withErrors(['email'=>'Invalid admin credentials']);
    }
}
