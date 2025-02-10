<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function addToken(Request $request){
        $lastWent = session('last_went', 0);
        $total = session('total_token', 0) + $request->token;

        session(['total_token'=>  $total ]);
        session(['last_went' => $lastWent]);

        return response()->json([
            'status' => 200,
            'message' => 'Tokens Added',
            'data' => [
                'total' => $total,
                'last_went' => $lastWent,
            ]
        ]);
    }

    public function issueToken(){
        try{
            $lastWent = session('last_went', 0);
            $total = session('total_token', 0);
            session(['total_token' => ++$total]);

            return response()->json([
                'status' => 200,
                'message' => 'Token Issued',
                'data' => [
                    'total' => $total,
                    'last_went' => $lastWent,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function clearSession(){
        session()->forget(['last_went', 'total_token', ]);

        return response()->json([
            'status' => 200,
            'message' => 'Session Cleared',
        ]);
    }
}
