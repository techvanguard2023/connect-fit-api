<?php

namespace App\Http\Controllers\Customer;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('userType')->get();
        return response()->json($customers);
    }

     public function showLoggedUser(Request $request)
    {
        $customer = $request->user();
        // Carregar a role e as permissões do usuário
        $customer->load('userType', 'subscriptions.plan', 'trainingFocuses', 'personalTrainerInfo', 'customerAddresses');
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_type_id'       => ['required', 'integer', 'exists:user_types,id'],
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email', 'max:255', 'unique:customers,email'],
            'phone'              => ['required', 'string', 'max:50'],
            'password'           => ['required', 'string', 'min:8'],
            'profile_picture'    => ['nullable', 'string', 'max:2048'],
            'email_verified_at'  => ['nullable', 'date'],
        ]);

        $customer = Customer::create($data); // cast 'hashed' cuida do password
        $customer->load('userType');

        return response()->json($customer, Response::HTTP_CREATED);
    }

    public function show(Customer $customer)
    {
        $customer->load('userType');
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'user_type_id'       => ['sometimes', 'required', 'integer', 'exists:user_types,id'],
            'name'               => ['sometimes', 'required', 'string', 'max:255'],
            'email'              => ['sometimes', 'required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('customers', 'email')->ignore($customer->id)],
            'phone'              => ['sometimes', 'required', 'string', 'max:50'],
            'password'           => ['sometimes', 'nullable', 'string', 'min:8'],
            'profile_picture'    => ['nullable', 'string', 'max:2048'],
            'email_verified_at'  => ['nullable', 'date'],
        ]);

        // Se password vier vazio/null, não atualiza
        if (array_key_exists('password', $data) && empty($data['password'])) {
            unset($data['password']);
        }

        $customer->update($data);
        $customer->load('userType', 'subscriptions');

        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        // Soft delete (porque sua tabela customers tem softDeletes)
        $customer->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
