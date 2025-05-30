<?php

namespace App\Http\Controllers\Chats;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Chats\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(Message::with(['discussion', 'user', 'reponse'])->get());
    }

    public function show($id)
    {
        return response()->json(Message::with(['discussion', 'user', 'reponse'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'discussion_id' => 'required|exists:discussions,id',
            'user_id' => 'required|exists:users,id',
            'reponse_id' => 'nullable|exists:messages,id',
            'contenu' => 'required|string',
            // 'statut' => 'required|string',
        ]);

        $message = new Message();

        $fields = [
            'discussion_id',
            'user_id',
            'reponse_id',
            'contenu',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $message->$field = $request->$field;
            }
        }
        $message->statut = 'ACTIVE';
        $message->save();
        return back();
        // broadcast(new MessageSent($message));
        // broadcast(new MessageSent($message->load('user')))->toOthers();
        // broadcast(new MessageSent($message))->toOthers();
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->all());

        return response()->json($message);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        // return response()->json(['message' => 'Message supprimé']);
        return back()->with('success', 'Suppression effectué avec succès.');
    }
}
