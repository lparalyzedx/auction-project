<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:buyer,seller'],
            'phone'    => ['required', 'string', 'max:20'],
        ];

        if ($request->role === 'seller') {
            $rules['tax_number']   = ['required', 'string', 'max:20', 'unique:seller_profiles,tax_number'];
            $rules['iban']         = ['required', 'string', 'min:26', 'max:34'];
            $rules['company_name'] = ['nullable', 'string', 'max:255'];
            $rules['id_document']  = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'];
        }

        $request->validate($rules);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'seller') {
            $documentPath = $request->file('id_document')
                ->store('seller-documents', 'private');

            SellerProfile::create([
                'user_id'              => $user->id,
                'company_name'         => $request->company_name,
                'tax_number'           => $request->tax_number,
                'iban'                 => $request->iban,
                'id_document_path'     => $documentPath,
                'verification_status'  => 'pending',
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

       return redirect()->route('verification.notice');
    }
}
