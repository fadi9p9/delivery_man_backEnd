<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // $user['token'] = $user->createToken('token')->plainTextToken;

        return response()->json(['message' => 'Logged in successfully'], 200);
    }


    public function destroy(Request $request)
    {
        $user = $request->user();
        if ($user) {
            // حذف التوكين الحالي
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'تم تسجيل الخروج بنجاح.',
            ], 200);
        }

        return response()->json([
            'message' => 'لم يتم العثور على مستخدم مصادق عليه.',
        ], 401);
    }
}
