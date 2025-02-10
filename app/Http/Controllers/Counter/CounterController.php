<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index(){
        return view('counter.index');
    }

    public function getToken($id)
{
    try {
        $total = session('total_token', 0);
        $lastWent = session('last_went', 0);

        if ($total == 0 || $total == $lastWent) {
            return response()->json([
                'status' => 404,
                'message' => 'No tokens available',
            ], 404);
        }

        // Increment the last_went to simulate the token being taken
        session(['last_went' => ++$lastWent]);

        return response()->json([
            'status' => 200,
            'message' => 'Token Retrieved',
            'data' => [
                'total' => $total,
                'last_went' => $lastWent,
            ],
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred: ' . $e->getMessage(),
        ], 500);
    }
}
}

