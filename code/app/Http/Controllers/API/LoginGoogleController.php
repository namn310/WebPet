<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\ErrorHandler\Throwing;
use Throwable;
use Illuminate\Support\Facades\DB;
use App\Models\User\GoogleUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Customer;


class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // dd('nam');
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            // Auth::guard('google_clients')->attempt(['email' => $google_user->getEmail(), 'password' => Hash::make($google_user->getEmail() . '@' . $google_user->getName())]);
            $user = DB::table('customer')->where('google_id', $google_user->getId())->first();
            if ($user) {
                Auth::guard('customer')->loginUsingId($user->id);
                return redirect(route('user.home'));
            } else {
                $newUser = new Customer();
                $newUser->name = $google_user->getName();
                $newUser->email = $google_user->getEmail();
                $newUser->google_id = $google_user->getId();
                $newUser->password = Hash::make($google_user->getEmail() . '@' . $google_user->getName());
                $newUser->save();
                $userDetail = [];
                $detail = DB::table('customer')->get()->where('google_id', $google_user->getId())->first();
                Auth::guard('customer')->loginUsingId($detail->id);
                return redirect(route('user.home'));
            }
            // return redirect(route('user.home'));
        } catch (Throwable) {
            return redirect(route('user.login'));
        }
    }
}
