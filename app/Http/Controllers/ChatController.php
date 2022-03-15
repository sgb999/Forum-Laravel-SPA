<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function store(User $user)
    {
        $chat = Chat::create([
            'user_id_1' => auth()->id(),
            'user_id_2' => $user->id
             ]);

        return inertia('message', compact(['chat']));
    }

    public function getChats()
    {
        $users1 = DB::table('users')
            ->join('chats', 'chats.user_id_2', '=', 'users.id')
            ->select('users.username', 'users.id')
            ->where('chats.user_id_1', '=', auth()->id())
            ->get()
            ->toArray();
        $users2 =  DB::table('users')
            ->join('chats', 'chats.user_id_1', '=', 'users.id')
            ->where('chats.user_id_2', '=', auth()->id())
            ->select('users.username', 'users.id')
            ->get()
            ->toArray();

        $users = array_merge($users1, $users2);

        return response()->json($users);
    }

    public function show($id)
    {

        $chat = Chat::where([
            ['user_id_1', $id],
            ['user_id_2', auth()->id()]
        ])
        ->orWhere([
            ['user_id_1', auth()->id()],
            ['user_id_2', $id]
        ])->first();

        if(!$chat){
            $chat = Chat::create([
                 'user_id_1' => auth()->id(),
                 'user_id_2' => $id
            ]);
        }
        return inertia('message', ['id' => $chat->id]);
    }

}
