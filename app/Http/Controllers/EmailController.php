<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\Email as Sender;
use App\Models\Email;
use Illuminate\Http\Request; 

class EmailController extends Controller
{
    // $email_controller = app()->make(EmailController::class);
    // $email_controller->store(Auth::user(), 'validation');

    public function index()
    {
        $emails = Email::all();
        return view('dashboard.pages.emails.index', compact('emails'));
    }

    public function create()
    {
        return view('dashboard.pages.emails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
        ]);

        $email = new Email;

        $fields = [
            'objet',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $email->$field = $request->$field;
            }
        }

        $fields = [
            'data',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $email->$field = json_encode($request->$field);
            }
        }
        $email->user_id = $request->user()->id;
        $email->save();
        return redirect()->route('emails.edit', $email->id)->with('success', 'Enregistrement effectué avec succès.');
    }

    public function show($id)
    {
        $email = Email::findOrFail(decrypter($id));
        return view('dashboard.pages.emails.view', compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $email = Email::findOrFail($id);
        return view('dashboard.pages.emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'data' => 'required',
        ]);
        $email = Email::where('id', $id)->first();

        $fields = [
            'objet',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $email->$field = $request->$field;
            }
        }

        $fields = [
            'data',
            'parametre'
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $email->$field = json_encode($request->$field);
            }
        }
        $email->user_id = $request->user()->id;
        $email->update();
        return back()->with('success', "Modification effectué avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $email = Email::findOrFail($id);
        $email->delete();
        return back()->with('success', 'Suppression effectué avec succès.');
    }
    public function SendMail($objet, $view, array $data)
    {
        try {
            $email = $data['email'];
            Mail::to($email)->send(new Sender($objet, $view, $data));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
