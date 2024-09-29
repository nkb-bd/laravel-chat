<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;


class ConversationOneToOne extends Model
{
    use HasFactory;
    public static function getUserConversations()
    {

        $userId = Auth::id(); // Get the authenticated user ID
        // Retrieve conversations using the ChatMessage model
        $conversations =  ChatMessage::with(['sender', 'receiver']) // Eager load relationships
        ->where(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
            ->select('id','text', 'sender_id', 'receiver_id', 'content', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($messages, $partnerId) {
                return [
                    'partner_id' => $partnerId,
                    'last_message' => $messages->first(), // Get the last message for this conversation
                    // You can include other message details if necessary
                ];
            });
        return $conversations;
    }
}
