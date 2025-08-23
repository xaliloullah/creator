<?php

namespace App\Http\Controllers;

use App\Notifications\NotificationCustom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // $notif_controller = app()->make(NotificationController::class);
    // $notif_controller->store(Auth::user(), 'title', 'test de message');

    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('dashboard.pages.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $notif_controller = app()->make(NotificationController::class);
        $notif_controller->store(Auth::user(), 'Success', 'test de message test de message test de message test de message test de message test de message test de messagetest de message test de message test de message', 'warning');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($user, $title = 'Notification', $message, $type = 'info')
    {
        $user->notify(new NotificationCustom($user, $title, $message, $type));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notification = Auth::user()->notifications->find($id);

        if (!$notification->reat_at) {
            $notification->markAsRead();
        }
        return view('dashboard.pages.notifications.view', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = Auth::user()->notifications->find($id);

        if ($notification) {
            $notification->delete();
        }
        return back()->with('success', 'Suppression effectué avec succès.');
    }

    public function statut($id)
    {
        $notification = Auth::user()->notifications->find($id);
        if (!$notification->read_at) {
            $notification->markAsRead();
            $notification->update();
        } else {
            $notification->read_at = null;
            $notification->update();
        }
        return back();
    }
    public function archive($id)
    {

        return back();
    }
}
