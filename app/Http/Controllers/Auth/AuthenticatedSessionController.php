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
    // تحقق من بيانات الاعتماد
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // احصل على المستخدم المصادق عليه
    $user = Auth::user();

    // أنشئ token جديدًا
    $token = $user->createToken('token')->plainTextToken;

    // أعد الاستجابة مع الـ token
    return response()->json([
        'message' => 'Logged in successfully',
        'token' => $token,
        'token_type' => 'Bearer', // اختياري لتمييز نوع المصادقة
    ], 200);
}
        
        // 'token' => $token,
        // $token = $user['token'] = Auth::attemptcreateToken('token')->plainTextToken;

    public function destroy(Request $request)
    {
        $user = $request->user();
        if ($user) {
           
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
