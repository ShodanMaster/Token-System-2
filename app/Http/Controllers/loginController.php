<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class loginController extends Controller
{
    public function index(){
        return view('login.authenticate');
    }

    public function LoggingIn(Request $request){
        // dd($request->all());
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $credentials = [
                'name' => $request->username,
                'password' => $request->password,
            ];

            $rememberMe = $request->has('rememberMe');

            if (auth()->attempt($credentials, $rememberMe)) {
                return redirect()->route('admin.index')->with('success', 'Logged In');
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
            }

        } catch (Exception $e) {
            Log::error('Login Failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function loggingOut(){
        auth()->logout();
        return redirect()->route('login')->with('success', 'logged Out');
    }
}
