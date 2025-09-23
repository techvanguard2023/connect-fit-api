<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        return $this->loginWithModel($request, User::class, 'user');
    }

    public function loginStudent(Request $request)
    {
        return $this->loginWithModel($request, Student::class, 'student');
    }

    public function loginEmployee(Request $request)
    {
        return $this->loginWithModel($request, Employee::class, 'employee');
    }

    private function loginWithModel(Request $request, $modelClass, string $tokenPrefix)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $modelClass::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $accessToken = $user->createToken("{$tokenPrefix}-token")->plainTextToken;

        $user->load('userType', 'subscriptions');

        return response()->json([
            'status' => 200,
            'message' => 'Authorized',
            'token' => $accessToken,
            'data' => [
                'user' => $user,
            ]
        ]);
    }

    public function checkTokenValidity(Request $request)
    {
        return response()->json([
            'authenticated' => true,
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'user_type_id'      => ['required', 'integer', 'exists:user_types,id'],
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'             => ['required', 'string', 'max:50'],
            'password'          => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'profile_picture'   => ['nullable', 'string', 'max:2048'],
            'email_verified_at' => ['nullable', 'date'],
            'opt_in'            => ['required', 'boolean'],
        ]);

        $user = DB::transaction(function () use ($data) {
            return User::create($data);
        });

        $user->load('userType', 'subscriptions');

        // Token de acesso via Sanctum
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }
}
