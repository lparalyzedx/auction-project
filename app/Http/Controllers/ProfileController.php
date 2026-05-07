<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    // Ad, telefon, avatar güncelle
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required'  => 'Ad Soyad zorunludur.',
            'phone.required' => 'Telefon zorunludur.',
        ]);

        $user->name  = $request->name;
        $user->phone = $request->phone;

        if ($request->hasFile('profile_image')) {
            // Eski avatarı sil
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('profile_image')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('profile_success', 'Profil bilgileriniz güncellendi.');
    }

    // E-posta güncelle
    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email'                => ['required', 'email', 'unique:users,email,' . $user->id],
            'confirmemailpassword' => ['required'],
        ], [
            'email.required'                => 'E-posta zorunludur.',
            'email.unique'                  => 'Bu e-posta zaten kullanılıyor.',
            'confirmemailpassword.required' => 'Mevcut şifrenizi girin.',
        ]);

        if (! Hash::check($request->confirmemailpassword, $user->password)) {
            return back()->withErrors(['confirmemailpassword' => 'Şifreniz hatalı.']);
        }

        $user->email                = $request->email;
        $user->email_verified_at    = null;
        $user->save();

        return back()->with('email_success', 'E-posta adresiniz güncellendi.');
    }

    // Şifre güncelle
    public function updatePassword(Request $request)
    {
        $request->validate([
            'currentpassword'       => ['required'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'currentpassword.required' => 'Mevcut şifrenizi girin.',
            'password.required'        => 'Yeni şifre zorunludur.',
            'password.confirmed'       => 'Şifreler eşleşmiyor.',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->currentpassword, $user->password)) {
            return back()->withErrors(['currentpassword' => 'Mevcut şifreniz hatalı.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('password_success', 'Şifreniz başarıyla güncellendi.');
    }
}