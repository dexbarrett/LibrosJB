<?php
namespace LibrosJB;

use DB;
use LibrosJB\ConversationInfo;
use Illuminate\Contracts\Cache\Repository as Cache;

class MessageManager
{
    protected $cache;
    protected $cacheUserKey = 'user-unread-messages-';

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function getConversationsForUser($userID)
    {
       return DB::table('conversations')
            ->select([
                'books.title as bookTitle', 'conversations.id',
                'user_settings.email_notifications',
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
            ->join('user_settings', 'conversation_info.user_id', '=', 'user_settings.user_id')
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

        $this->decrementTotalUnreadMessagesForUser(
            auth()->user()->id, $conversation->unread_messages
        );

        $conversation->unread_messages = 0;
        $conversation->save();

        DB::table('messages')
            ->where('conversation_id', $conversationID)
            ->where('to_user', auth()->user()->id)
            ->where('read', false)
            ->update(['read' => true]);
    }

    public function getTotalUnreadMessagesForUser($userID)
    {
        $totalUnreadMessages = $this->cache->rememberForever($this->getUserCacheKey($userID), function() use ($userID) {
            return (int) $this->getTotalUnreadMessagesForUserFromDB($userID);
        });

        return $totalUnreadMessages;
    }

    public function incrementTotalUnreadMessagesForUser($userID, $amount = 1)
    {
        if ($this->userMessagesNotInCache($userID)) {
            $this->getTotalUnreadMessagesForUser($userID);
        }

        $this->cache->increment($this->getUserCacheKey($userID), $amount);
    }

    public function decrementTotalUnreadMessagesForUser($userID, $amount = 1)
    {
        if ($this->userMessagesNotInCache($userID)) {
            $this->getTotalUnreadMessagesForUser($userID);
        }

        $this->cache->decrement($this->getUserCacheKey($userID), $amount);
    }

    protected function getTotalUnreadMessagesForUserFromDB($userID)
    {
        return ConversationInfo::where('user_id', $userID)->sum('unread_messages');
    }

    protected function getUserCacheKey($userID)
    {
        return $this->cacheUserKey . $userID;
    }

    protected function userMessagesNotInCache($userID)
    {
        return ! $this->cache->has($this->getUserCacheKey($userID));
    }
}