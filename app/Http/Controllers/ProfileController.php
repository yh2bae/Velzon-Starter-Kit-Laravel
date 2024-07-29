<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->path = 'pages.profile.';
    }

    public function index()
    {
        $user = Auth::user();

        $data = [
            'page_title' => 'Profil',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'profile' => ['title' => 'Profil', 'url' => route('profile')],
            ],
            'user' => $user,
        ];

        return view($this->path . 'index', $data);
    }

    public function changePasswordView()
    {
        $user = Auth::user();

        $data = [
            'page_title' => 'Ubah Password',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'profile' => ['title' => 'Profil', 'url' => route('profile')],
                'change_password' => ['title' => 'Ubah Password', 'url' => route('change-password')],
            ],
            'user' => $user,
        ];

        return view($this->path . 'change-password', $data);
    }

    public function update(ProfileRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validated();

            $user = Auth::user();

            $user->update([
                'name' => $request->name,
            ]);
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $name_user = str_replace(' ', '_', strtolower($user->name));
                $avatarName = $name_user . '_' . time() . '.' . $avatar->getClientOriginalExtension();

                if ($user->profile && $user->profile->avatar) {
                    Storage::delete('public/avatars/' . basename($user->profile->avatar));
                }

                $avatar->storeAs('public/avatars', $avatarName);
                $avatarPath = 'avatars/' . $avatarName;
            } else {
                $avatarPath = $user->profile->avatar ? ('avatars/' . basename($user->profile->avatar)) : null;
            }

            $profileData = [
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $avatarPath,
            ];

            if ($user->profile) {
                if ($profileData['avatar'] == 'avatars/user-dummy-img.jpg') {
                    unset($profileData['avatar']);
                }

                $user->profile()->update($profileData);
            } else {
                $user->profile()->create($profileData);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Profil gagal diperbarui');
        }

    }

    public function updatePassword(PasswordRequest $request)
    {
        try {
            $request->validated();

            $user = Auth::user();

            if (!password_verify($request->password_old, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak cocok');
            }

            $user->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->back()->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Password gagal diperbarui');
        }
    }
}
