<?php

namespace App\Http\Controllers;

use App\Models\TempoarayFile;
use App\Http\Requests\{ImagePostRequest, UserEditRequest, UserStoreRequest, UserLoginRequest};
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

    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     */
    public function register(UserStoreRequest $request){
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            if($validated['avatar'] !== null){
                $tempFile = TempoarayFile::where('folder', $validated['avatar'])->first();
                $user->addMedia(storage_path('app/public/avatars/tmp/' . $validated['avatar'] . '/' . $tempFile->filename))
                ->toMediaCollection('avatar');
                rmdir(storage_path('app/public/avatars/tmp/' . $validated['avatar']));
                $tempFile->delete();
            }
            if(auth()->attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ])){
                return redirect()->to(route('home'));
            }
    }

    public function profile($username)
    {
        $user = User::where('username', $username)
            ->with('media')
            ->select('id', 'username')
            ->first();
        return inertia('profile', compact(['user']));
    }

    public function getUser($id){
        return response()->json(
            User::whereId($id)
            ->with('media')
            ->select('id')
            ->first()
        );
    }

    public function updateProfilePage($username)
    {
        $user = User::where('username', $username)
            ->with('media')
            ->select('id', 'name', 'username', 'email')
            ->first();
        abort_unless($user->id == auth()->id(), 403);
        return inertia('update-profile', compact(['user']));
    }

    public function updateProfile(User $user, UserEditRequest $request)
    {
        abort_unless($user->id == auth()->id(), 403);
        $validated  = $request->validated();
        array_filter($validated);
        if(array_key_exists('banner', $validated) || array_key_exists('avatar', $validated)){
            foreach ($validated as $key => $value){
                $tempFile = TempoarayFile::where('folder', $value)->first();
                $user->clearMediaCollection($key);
                $user->addMedia(storage_path('app/public/' . $key . '/tmp/' . $value . '/' . $tempFile->filename))
                    ->toMediaCollection($key);
                rmdir(storage_path('app/public/' . $key . '/tmp/' . $value));
                $tempFile->delete();
            }
        }
        $user->update($validated);
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

    public function storeImage(ImagePostRequest $request): string
    {
        $folder = '';
        foreach (array_filter($request->validated()) as $key => $value) {
            $file     = $request->file($key);
            $filename = $file->getClientOriginalName();
            $folder   = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/public/' . $key . '/tmp/' . $folder, $filename);

            TempoarayFile::create([
                  'folder'   => $folder,
                  'filename' => $filename
              ]);
        }
        return $folder;
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
