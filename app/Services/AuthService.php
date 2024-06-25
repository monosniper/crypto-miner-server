<?php

namespace App\Services;

use App\Helpers\TapApp;
use App\Jobs\SendVerificationMail;
use App\Mail\ForgotPassword;
use App\Models\ForgotPasswordCode;
use App\Models\Ref;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function sendVerificationMail(): bool
    {
        SendVerificationMail::dispatch(auth()->user());
        return true;
    }

    public function register($data): bool
    {
        if(isset($data['ref_code'])) {
            $data['ref_id'] = Ref::where('code', $data['ref_code'])->first()?->id;
        }

        $user = User::create($data);

//        $basic  = new \Vonage\Client\Credentials\Basic(env("VONAGE_KEY"), env("VONAGE_SECRET"));
//        $client = new \Vonage\Client($basic);
//
//        $response = $client->sms()->send(
//            new \Vonage\SMS\Message\SMS($data->phone, env('APP_NAME'), 'Your verification code: 123456')
//        );
//
//        $message = $response->current();
//
//        if ($message->getStatus() == 0) {
//            info("The message was sent successfully");
//        } else {
//            info("The message failed with status: " . $message->getStatus());
//        }

        TapApp::siteVisited($user->id);
        SendVerificationMail::dispatch($user);

        return (bool) $user;
    }

    public function verificateMail(string $code): RedirectResponse
    {
        $code = VerificationCode::where('value', $code)->first();

        if($code) {
            $code->user->update([
                'isVerificated' => true,
            ]);

            $code->delete();

            return redirect()->away(config("app.front_url") . "?success=true&type=verificated");
        }

        return redirect()->away(config("app.front_url") . "?success=false");
    }

    public function forgotPassword(string $email): bool
    {
        $user = User::where('email', $email)->first();

        $code = ForgotPasswordCode::create([
            'user_id' => $user->id,
        ]);
        Mail::to($email)->send(new ForgotPassword($code->value));

        return true;
    }

    public function updatePassword($data): bool
    {
        $code = ForgotPasswordCode::where('value', $data['code'])->first();

        $code->user->update([
            'password' => $data['password']
        ]);
        $code->delete();

        return true;
    }

    public function login($data): bool
    {
        if (Auth::attempt($data)) {
            request()->session()->regenerate();

            TapApp::siteVisited();

            return true;
        }

        return false;
    }

    public function checkPasswordCode(): bool
    {
        return true;
    }

    public function checkUsername(): bool
    {
        return true;
    }
}
