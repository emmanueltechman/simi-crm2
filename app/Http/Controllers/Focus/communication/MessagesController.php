<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\communication;

use App\Models\Access\User\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */


    public function index()
    {

        // All threads, ignore deleted/archived participants
        //$threads = Thread::getAllLatest()->where('user_id','=',$user->id)->get();

        // All threads that user is participating in

        $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        //    $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('focus.messenger.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('biller.messages');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        //$userId = Auth::id();
        $user = Auth::user();
        $users = User::where('ins', '=', $user->ins)->whereNotIn('id', $thread->participantsUserIds($user->id))->get();


        $thread->markAsRead($user->id);

        return view('focus.messenger.show', compact('thread', 'users'));
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        $user = Auth::user();
        $users = User::where('ins', '=', $user->ins)->where('id', '!=', $user->id)->get();
        return view('focus.messenger.create', compact('users'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store()
    {
        $input = Request::all();

        if ($input['message']) {

            $thread = Thread::create([
                'subject' => $input['subject'],
            ]);

            // Message
            Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => $input['message'],
            ]);

            // Sender
            Participant::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'last_read' => new Carbon,
            ]);

            // Recipients
            if (Request::has('recipients')) {
                $thread->addParticipant($input['recipients']);
            }
        }

        return redirect()->route('biller.messages');
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('biller.messages');
        }

        $thread->activateAllParticipants();

        // Message
        if (@Request::input('message')) {
            Message::create([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => Request::input('message'),
            ]);

            // Add replier as a participant
            $participant = Participant::firstOrCreate([
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
            ]);
            $participant->last_read = new Carbon;
            $participant->save();

            // Recipients
            if (Request::has('recipients')) {
                $thread->addParticipant(Request::input('recipients'));
            }
        }

        return redirect()->route('biller.messages.show', $id);
    }

    public function destroy(\Illuminate\Http\Request $request)
    {
        try {

            $message = Message::find($request->id);
            $id = $message->thread_id;
            if ($message->user_id == auth()->user()->id) $message->delete();
            return json_encode(array('done'));
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('biller.messages');
        }


    }
}
