<?php
namespace LibrosJB\Listeners;

use LibrosJB\ConversationInfo;
use LibrosJB\Events\MessagePublished;

class MessageEventListener
{
    public function onMessageCreated(MessagePublished $event)
    {
        $message = $event->message;

        $conversationInfo = ConversationInfo::where('conversation_id', $message->conversation_id)
                            ->where('user_id', $message->to_user)
                            ->firstOrFail();

        $conversationInfo->unread_messages ++;
        $conversationInfo->save();

    }

    public function subscribe($events)
    {
        $events->listen(
            MessagePublished::class,
            'LibrosJB\Listeners\MessageEventListener@onMessageCreated'
        );
    }
}