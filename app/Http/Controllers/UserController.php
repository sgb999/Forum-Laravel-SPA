<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\{UserEditRequest, UserStoreRequest, UserLoginRequest};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginPage(){
        return inertia('Login');
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->to(route('home'));
        }
        else{
            return redirect()->back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function register(UserStoreRequest $request){
            $validated = $request->validated();

            User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);
            if(auth()->attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ])){
                return redirect()->to(route('home'));
            }
    }

    public function profile(User $user)
    {
        return inertia('profile', compact(['user']));
    }

    public function updateProfilePage(User $user)
    {
        return inertia('update-profile', compact(['user']));
    }

    public function updateProfile(User $user, UserEditRequest $request)
    {
        abort_unless($user->id == auth()->id(), 403);
        $validated  = $request->validated();
        $user->update($validated);
        $user->save();
        return response()->json(200);
    }

    public function registerPage()
    {
        return inertia('Register');
    }

    public function logOutMethod(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('home');
    }
}
