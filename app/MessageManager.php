<?php
namespace LibrosJB;

use DB;
use LibrosJB\ConversationInfo;

class MessageManager
{
    public function getConversationsForUser($userID)
    {
       return DB::table('conversations')
            ->select([
                'books.title as bookTitle', 'conversations.id',
                'conversation_info.unread_messages as unreadCount',
                 DB::raw('max(messages.created_at) as lastMessage'),
            ])
            ->where('conversations.from_user', $userID)
            ->orWhere('conversations.to_user', $userID)
            ->join('books', 'conversations.book_id', '=', 'books.id')
            ->join('messages', 'conversations.id', '=', 'messages.conversation_id')
            ->join('conversation_info', function($join) use ($userID){
                $join->on('conversations.id', '=', 'conversation_info.conversation_id')
                ->where('conversation_info.user_id', '=', $userID);
            })
            ->groupBy('messages.conversation_id')
            ->orderBy('lastMessage', 'DESC')
            ->get();
    }

    public function clearUnreadMessagesForUser($conversationID)
    {
        $conversation = ConversationInfo::where('conversation_id', $conversationID)
            ->where('user_id', auth()->user()->id)->first();

        if (is_null($conversation)) {
            return;
        }

        $conversation->unread_messages = 0;
        $conversation->save();
    }
}