<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Database\Eloquent\Casts\Json;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        Log::info('Login request received', ['loginname' => $request->loginname]);


        $request->authenticate();

        $user = $request->user();

        $user->tokens()->delete();

        $token = $user->createToken('api-token');

        $userData = $user->toArray();
        $userData['token'] = $token->plainTextToken;

        if ($user->role === 'admin') {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $user,
                    'token' => $token->plainTextToken,
                    'redirect' => route('admin.dashboard'),
                ]);
            } else {
                return redirect()->route('admin.dashboard');
            }
        } else {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $user,
                    'token' => $token->plainTextToken,
                    'redirect' => route('dashboard'), // Ubah route sesuai dengan route home utama Anda
                ]);
            } else {
                return redirect()->route('dashboard');
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
