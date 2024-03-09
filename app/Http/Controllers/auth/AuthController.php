<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|unique:users|string',
            'document_number' => 'required|digits:10',
            'password' => 'required|string'
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'document_number' => $request->document_number,
            'password' => Hash::make($request->password)
        ]);

        return response('', 204);
    }

    public function login(Request $request) {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $foundUser = User::where('phone', $request->phone)->first();

        if (!$foundUser || !Hash::check($request->password, $foundUser->password)) {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'errors' => [
                        'phone' => ['phone or password incorrect']
                    ]
                ]
            ]);
        }

        $token = $foundUser->createToken('api')->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function userBookings(Request $request) {
        return $request->user()->bookings;
    }
}
