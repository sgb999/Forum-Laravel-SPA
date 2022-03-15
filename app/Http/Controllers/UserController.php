<?php

namespace App\Http\Controllers;

use App\Http\Requests\{UserEditRequest, UserStoreRequest, UserLoginRequest};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
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
        abort_unless($user->id == auth()->id(), 403);
        return inertia('update-profile', compact(['user']));
    }

    public function updateProfile(User $user, UserEditRequest $request)
    {
        abort_unless($user->id == auth()->id(), 403);
        $validated  = $request->validated();
        $user->update(array_filter($validated));
        $user->save();
        return back();
    }

    public function destroy(User $user)
    {
        abort_unless($user->id === auth()->id(), 403);
        $user->delete();
        return back();
    }

    public function logOutMethod(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * can be used on profile page, is quicker to execute but would require a new vue component

    public function getUserPosts($id)
    {
        return response()->json(
            User::whereId($id)
                ->with(['post' => function ($query){
                   $query->with('category:id,name')
                   ->select('id', 'title', 'user_id', 'category_id', 'created_at')
                   ->orderBy('created_at', 'desc');
                }])->select('id', 'username')
                ->paginate(10)
        );
    }*/
}
