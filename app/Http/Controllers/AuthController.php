<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->path = 'pages.auth.';
    }

    public function login()
    {
        $data = [
            'page_title' => 'Login',
        ];

        return view($this->path . 'login', $data);
    }

    public function register()
    {
        $data = [
            'page_title' => 'Register',
        ];

        return view($this->path . 'register', $data);
    }

    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();

                if (!Auth::user()->hasVerifiedEmail()) {
                    Auth::user()->sendEmailVerificationNotification();
                }

                return redirect()->intended('/home')->with('success', 'Login berhasil');
            }

            return back()->with('error', 'Email atau Password salah');

        } catch (\Exception $e) {
            return back()->with('error', 'Login gagal');
        }
    }

    public function registerStore(RegisterRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $request->validated();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('user');

            $user->profile()->create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            Auth::login($user);

            DB::commit();

            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.view')->with('success', 'Register berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('register')->with('error', 'Register gagal');

        }
    }

    public function verificationView(Request $request)
    {
        $data = [
            'page_title' => 'Verifikasi Email',
        ];

        return $request->user()->hasVerifiedEmail()
        ? redirect()->intended('/home')
        : view('pages.auth.verification', $data);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home')->with('success', 'Email verified!');
    }

    public function resendEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    public function forgotPassword()
    {
        $data = [
            'page_title' => 'Reset Password',
        ];

        return view($this->path . 'reset-password-email', $data);
    }

    public function sendResetPasswordLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        try {
            if (!$user) {
                return back()->with('error', 'Email tidak ditemukan');
            }

            // delte old token
            if (DB::table('password_reset_tokens')->where('email', $request->email)->first()) {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            }

            $plainToken = Str::random(60);
            $hashedToken = Hash::make($plainToken);

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $hashedToken,
                'created_at' => now(),
            ]);

            Mail::send('emails.reset-password', ['token' => $plainToken, 'user' => $user], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('success', trans('Link reset password telah dikirim.'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim link reset password');
        }
    }

    public function resetPasswordWithToken($token)
    {
        $data = [
            'page_title' => 'Reset Password',
            'token' => $token,
        ];

        return view($this->path . 'reset-password', $data);
    }

    public function resetPasswordUpdate(ResetPasswordRequest $request, $token)
    {

        try {
            $request->validated();

            $passwordResetTokens = DB::table('password_reset_tokens')->get();

            $passwordResetToken = null;

            foreach ($passwordResetTokens as $prt) {
                if (Hash::check($token, $prt->token)) {
                    $passwordResetToken = $prt;
                    break;
                }
            }

            if (!$passwordResetToken) {
                return back()->with('error', 'Token tidak valid');
            }

            $user = User::where('email', $passwordResetToken->email)->first();

            if (!$user) {
                return back()->with('error', 'User tidak ditemukan');
            }

            $user->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return redirect()->route('login')->with('success', 'Password berhasil direset');

        } catch (\Exception $e) {
            return back()->with('error', 'Password gagal direset');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logout berhasil');
    }

}
