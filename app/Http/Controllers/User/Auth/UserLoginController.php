<?php

namespace App\Http\Controllers\User\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function index(){
        return view('user.auth.login');
    }

    public function login(Request $request){
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        try{
            // Attempt to login using Auth
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate(); // prevent session fixation
                return redirect()->intended('/dashboard'); // or route('dashboard')
            }
        
            // If login failed
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

        }catch(\Exception $e){
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }

    public function logout(Request $request){
        try{

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Logged out successfully!');
        }catch(\Exception $e){
            return redirect('/')->with('error', 'Something went wrong!');
        }
    }
}
