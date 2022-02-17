<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Load the main view.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Save the user information from Google and log them in.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        $google_user = Socialite::driver('google')->user();
        $local_user = User::where('google_id', $google_user->id)->first();
        $redirect = '/';

        if (!$local_user) {
            $local_user = $this->createUser($google_user);
        }

        Auth::login($local_user);

        if (session()->has('url.intended')) {
            $redirect = session()->get('url.intended');
            session()->forget('url.intended');
        }

        return redirect($redirect);
    }

    /**
     * Save the user to the database.
     * @param \Laravel\Socialite\Two\User $user
     */
    private function createUser($user): User
    {
        $local_user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
        ]);

        $local_user->save();

        return $local_user;
    }
}
