<?php
namespace LibrosJB\Listeners;

use LibrosJB\MessageManager;
use LibrosJB\ConversationInfo;
use LibrosJB\Events\MessagePublished;

class MessageEventListener
{
    protected $MessageManager;

    public function __construct(MessageManager $MessageManager)
    {
        $this->MessageManager = $MessageManager;
    }

    public function onMessageCreated(MessagePublished $event)
    {
        $message = $event->message;

        $conversationInfo = ConversationInfo::where('conversation_id', $message->conversation_id)
                            ->where('user_id', $message->to_user)
                            ->firstOrFail();


        $this->MessageManager->incrementTotalUnreadMessagesForUser($message->to_user);

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