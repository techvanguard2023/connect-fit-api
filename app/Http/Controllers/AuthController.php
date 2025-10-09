<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        //Usuários podem fazer login como User
        return $this->loginWithModel($request, User::class, 'user');
    }

    public function loginCustomer(Request $request)
    {
        //Personais ou Nutricionistas podem fazer login como Customer
        return $this->loginWithModel($request, Customer::class, 'customer');
    }

    public function loginEmployee(Request $request)
    {
        //Funcionários podem fazer login como Employee
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

        $user->load('userType', 'subscriptions.plan', 'trainingFocuses', 'personalTrainerInfo');

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
            'customer' => $request->user()
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
            'email'             => ['required', 'email', 'max:255', 'unique:customers,email'],
            'phone'             => ['required', 'string', 'max:50'],
            'password'          => ['required', PasswordRule::min(8)->mixedCase()->numbers()->symbols()],
            'profile_picture'   => ['nullable', 'string', 'max:2048'],
            'email_verified_at' => ['nullable', 'date'],
            'opt_in'            => ['required', 'boolean'],
        ]);

        $customer = DB::transaction(function () use ($data) {
            return Customer::create($data);
        });

        $customer->load('userType', 'subscriptions');

        // Token de acesso via Sanctum
        $token = $customer->createToken('api')->plainTextToken;

        return response()->json([
            'customer'  => $customer,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }


   // Envia o link de reset para o e-mail do usuário
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], Response::HTTP_OK);
        }

        // INVALID_USER, etc.
        return response()->json(['message' => __($status)], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Reseta a senha com token + email
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'                 => ['required', 'email'],
            'token'                 => ['required'],
            'password'              => ['required', PasswordRule::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            // ESPERA password_confirmation no payload
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Revoga TODOS os tokens Sanctum após reset
                if (method_exists($user, 'tokens')) {
                    $user->tokens()->delete();
                }

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], Response::HTTP_OK);
        }

        return response()->json(['message' => __($status)], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
