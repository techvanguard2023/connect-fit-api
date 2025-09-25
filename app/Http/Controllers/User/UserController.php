<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('userType')->get();
        return response()->json($users);
    }

     public function showLoggedUser(Request $request)
    {
        $user = $request->user();
        // Carregar a role e as permissões do usuário
        $user->load('userType', 'subscriptions.plan');
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_type_id'       => ['required', 'integer', 'exists:user_types,id'],
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'              => ['required', 'string', 'max:50'],
            'password'           => ['required', 'string', 'min:8'],
            'profile_picture'    => ['nullable', 'string', 'max:2048'],
            'email_verified_at'  => ['nullable', 'date'],
        ]);

        $user = User::create($data); // cast 'hashed' cuida do password
        $user->load('userType');

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        $user->load('userType');
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'user_type_id'       => ['sometimes', 'required', 'integer', 'exists:user_types,id'],
            'name'               => ['sometimes', 'required', 'string', 'max:255'],
            'email'              => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'              => ['sometimes', 'required', 'string', 'max:50'],
            'password'           => ['sometimes', 'nullable', 'string', 'min:8'],
            'profile_picture'    => ['nullable', 'string', 'max:2048'],
            'email_verified_at'  => ['nullable', 'date'],
        ]);

        // Se password vier vazio/null, não atualiza
        if (array_key_exists('password', $data) && empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);
        $user->load('userType', 'subscriptions');

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        // Soft delete (porque sua tabela users tem softDeletes)
        $user->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
