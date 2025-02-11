<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function addToken(Request $request){

        try{

            $token = Token::where('date', Carbon::today())->first();

            if($token){
                $token->update([
                    'total_token' => $token->total_token + $request->token,
                ]);
            }else{

                $token = Token::create([
                    'total_token' => $request->token,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Tokens Added',
                'data' => [
                    'total' => $token->total_token,
                    'last_went' => $token->last_went,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function issueToken(){

        try{
            $token = Token::where('date', Carbon::today())->first();

            if($token){
                $token->update([
                    'total_token' => $token->total_token + 1,
                ]);
            }else{

                $token = Token::create([
                    'total_token' => $token->total_token + 1,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Token Issued',
                'data' => [
                    'total' => $token->total_token,
                    'last_went' => $token->last_went,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getToken(){
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

    public function clearSession(){
        session()->forget(['last_went', 'total_token', ]);

        return response()->json([
            'status' => 200,
            'message' => 'Session Cleared',
        ]);
    }
}
