<?php

namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function index(){
     
        return view('admin.auth.login');
    }



    public function login(Request $request){
        // Validate the request
      $credentials =   $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // dd($credentials);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt($credentials)) {
            // dd('auth');
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->intended('admin/dashboard'); // or route('dashboard')
        }



        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin')->with('success', 'Logged out successfully!');
    }
}
