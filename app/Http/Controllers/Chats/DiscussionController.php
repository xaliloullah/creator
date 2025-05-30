<?php

namespace App\Http\Controllers\Chats;

use App\Http\Controllers\Controller;
use App\Models\Chats\Discussion;
use Illuminate\Http\Request;
use App\Models\User;

class DiscussionController extends Controller
{
    public function index()
    {
        return response()->json(Discussion::with('messages')->get());
    }

    public function create(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)->get();
        return view('dashboard.modules.chats.discussions.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'designation' => 'nullable|string',
            'type' => 'required|string',
            'membres' => 'required|array'
        ]);
        $membres = array_merge([$request->user()->id], $request->membres);
 
        if ($request->type === 'MP' && count($membres) === 2) {
            $existingDiscussion = Discussion::where('type', 'MP')
                ->whereHas('users', function ($query) use ($membres) {
                    $query->whereIn('users.id', $membres);
                }, '=', count($membres))
                ->first();

            if ($existingDiscussion) {
                return redirect()->route('discussions.show', $existingDiscussion->id);
            }
        }

        $discussion = new Discussion();

        $fields = [
            'user_id',
            'designation',
            'type',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $discussion->$field = $request->$field;
            }
        }

        // type 
        // MP (Messages Privés)
        // GROUP
        // TICKET
        // ...

        $discussion->statut = 'ACTIVE';
        $discussion->save();
        $discussion->Users()->attach($membres, ['discussion_id' => $discussion->id, 'statut' => 'GUEST']);
        return redirect()->route('discussions.show', $discussion->id);
    }

    public function show($id)
    {
        $discussion = Discussion::findOrFail($id);
        return view('dashboard.modules.chats.discussions.view', compact('discussion'));
    }

    public function update(Request $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
        $discussion->update($request->all());

        return response()->json($discussion);
    }

    public function destroy($id)
    {
        Discussion::findOrFail($id)->delete();

        return response()->json(['message' => 'Discussion supprimée']);
    }
}
