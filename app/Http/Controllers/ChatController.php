<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;

use function array_merge;

class ChatController extends Controller
{
    public function store(User $user) : Response|ResponseFactory
    {
        return inertia(
            'message',
            [
                'chat' => Chat::create([
                    'user_id_1' => auth()->id(),
                    'user_id_2' => $user->id,
                ]),
            ]
        );
    }

    public function getChats() : JsonResponse
    {
        $users1 = DB::table('users')
        ->join('chats', 'chats.user_id_2', '=', 'users.id')
        ->select('users.username', 'users.id')
        ->where('chats.user_id_1', '=', auth()->id())
        ->get()
        ->toArray();
        $users2 = DB::table('users')
        ->join('chats', 'chats.user_id_1', '=', 'users.id')
        ->where('chats.user_id_2', '=', auth()->id())
        ->select('users.username', 'users.id')
        ->get()
        ->toArray();

        $users = array_merge($users1, $users2);

        return response()->json($users);
    }

    public function show(int $id) : Response|ResponseFactory
    {
        $chat = Chat::where([
            ['user_id_1', $id],
            ['user_id_2', auth()->id()],
        ])
        ->orWhere([
            ['user_id_1', auth()->id()],
            ['user_id_2', $id],
        ])->first();

        if (! $chat) {
            $chat = Chat::create([
                'user_id_1' => auth()->id(),
                'user_id_2' => $id,
            ]);
        }
        return inertia('message', [
            'id'       => $chat->id,
            'messages' => route('message.index', $id),
        ]);
    }
}
