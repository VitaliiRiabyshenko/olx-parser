<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class VerifyEmailController extends Controller
{
    public function index()
    {
        return view('verify-email', ['user' => auth()->user()]);
    }

    public function send(Request $request)
    {
        $randomToken = Str::random(64);

        Cache::put(auth()->user()->email, $randomToken, now()->addMinutes(60));

        $url = route('verify-email', ['id' => auth()->user()->id, 'hash' => $randomToken]);

        try {
            Mail::to($request->email)->send(new VerifyEmail(['url' => $url]));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route('user-parser.index');
    }

    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user-parser.index');
        }

        if (($user->email != auth()->user()->email) || $hash != Cache::get($user->email)) {
            abort(401);
        }

        $user->markEmailAsVerified();

        return redirect()->route('user-parser.index');
    }
}