<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ConversationOneToOne;

class HomeController extends Controller
{
    public function index($conversationID = null)
    {
        // Use the Conversation model to get user conversations
        $conversations = ConversationOneToOne::getUserConversations();
        $formattedConversations = $conversations->map(function ($conversation) {
            // Format the 'created_at' timestamp as a human-readable string
            $conversation['last_message']->created_at_diff = Carbon::parse($conversation['last_message']->created_at)->diffForHumans();


            // Return the modified conversation
            return $conversation;
        });
        return view('index', [
            'conversations'      => $formattedConversations,
            'activeConversation' => $conversations->first(),
            'currentUser'        => auth()->user()
        ]);
    }

    public function getChatData($friendId)
    {

        // Fetch the friend by ID
        $friend = User::findOrFail($friendId);

        // Fetch messages with eager loading for sender and receiver
        $messages = ChatMessage::query()
            ->where(function ($query) use ($friend) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($query) use ($friend) {
                $query->where('sender_id', $friend->id)
                    ->where('receiver_id', auth()->id());
            })
            ->with(['sender:id,name', 'receiver:id,name']) // Eager load sender and receiver
            ->orderBy('id', 'asc')
            ->get();

        // Return the response as JSON
        return response()->json([
            'messages' => $messages,
            'friend' => $friend, // Include friend details
        ]);
    }

}
