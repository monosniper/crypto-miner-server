<?php

namespace App\Services;

use App\Http\Resources\NftResource;
use App\Mail\ForgotPassword;
use App\Models\ForgotPasswordCode;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function sendVerificationMail(): bool
    {
        return true;
    }

    public function verificateMail(string $code): \Illuminate\Http\RedirectResponse
    {
        $code = VerificationCode::where('value', $code)->first();

        if($code) {
            $code->user->update([
                'isVerificated' => true,
            ]);

            $code->delete();

            return redirect()->away(env("FRONT_URL") . "?success=true&type=verificated");
        }

        return redirect()->away(env("FRONT_URL") . "?success=false");
    }

    public function forgotPassword(string $email): bool
    {
        $user = User::where('email', $email)->first();
        $success = true;

        if($user) {
            $code = ForgotPasswordCode::create([
                'user_id' => $user->id,
            ]);
            Mail::to($email)->send(new ForgotPassword($code->value));
        } else $success = false;

        return $success;
    }

    public function updatePassword($data): bool
    {
        $success = true;
        $code = ForgotPasswordCode::where('value', $data['code'])->first();

        if($code) {
            $code->user->update([
                'password' => $data['password']
            ]);
            $code->delete();
        } else $success = false;

        return $success;
    }

    public function checkPasswordCode($data) {
        return (bool) ForgotPasswordCode::where('value', $data['code'])->first();
    }

    public function checkUsername($data) {
        return (bool) User::where('name', $data['username'])->first();
    }

    public function nfts(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $nfts = Auth::user()->nfts;

        return NftResource::collection($nfts);
    }
}
