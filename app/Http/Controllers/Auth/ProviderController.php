<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;

class ProviderController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider){
        // try{
        //     $AuthUser = Socialite::driver($provider)->user();
        //     if(User::where('email',$AuthUser->getEmail())->exists()){
        //         return redirect('/login')->withErrors(['email'=>'This Email is exists use Different Email']);
        //     }
        //     $user = User::where([
        //         'provider_id' => $AuthUser->id,
        //         'provider' => $provider

        //     ])->first();
        //     if(!$user){
        //         $user = User::create([
        //         'name' => $AuthUser->getName(),
        //         'email' => $AuthUser->getEmail(),
        //         'provider_token' => $AuthUser->token,
        //         'provider' => $provider,
        //         'provider_id' => $AuthUser->getId(),
        //         'email_verified_at' => now(),
        //         ]);
        //     }
        //     Auth::login($user);
        //     return redirect('/dashboard');
        // }catch(\Exception $e){
        //     return redirect('/login');
        // }
        $AuthUser = Socialite::driver($provider)->user();
        $user = User::updateOrCreate([
            'provider_id' => $AuthUser->id,
            'provider' => $provider
        ],[
            'name' => $AuthUser->name,
            'email' => $AuthUser->email,
            'provider_token' => $AuthUser->token,
          
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
