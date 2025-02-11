<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index(){
        return view('counter.index');
    }

    public function getToken($id){

        // dd(session('total_token', 0));
        try {
            // $total = session('total_token', 0);
            // $lastWent = session('last_went', 0);

            $token = Token::where('date', Carbon::today())->first();

            if (!$token) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No tokens available for today',
                ], 404);
            }


            if ($token->total_token == 0 || $token->total_token == $token->last_went) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No tokens available',
                ], 404);
            }

            // Increment the last_went to simulate the token being taken
            // session(['last_went' => ++$lastWent]);

            $token->increment('last_went');

            $tokenLeft = $token->total_token - $token->last_went;
            return response()->json([
                'status' => 200,
                'message' => 'Token Retrieved',
                'data' => [
                    'total' => $token->total_token,
                    'last_went' => $token->last_went,
                    'token_left' => $tokenLeft,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getTokenInfo(){
        try{

            $token = Token::where('date', Carbon::today())->first();

            if (!$token) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No token found for today',
                ], 404);
            }

            $tokenLeft = $token->total_token - $token->last_went;

            return response()->json([
                'status' => 200,
                'message' => 'Token Issued',
                'data' => [
                    'total' => $token->total_token,
                    'last_went' => $token->last_went,
                    'token_left' => $tokenLeft,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}

