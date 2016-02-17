<?php
namespace LibrosJB\Listeners;

use LibrosJB\User;
use LibrosJB\MessageManager;
use LibrosJB\ConversationInfo;
use LibrosJB\Events\MessagePublished;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LibrosJB\Jobs\SendMessageNotificationEmail;

class MessageEventListener
{
    protected $MessageManager;

    use DispatchesJobs;

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

        if (User::findOrFail($message->to_user)->hasEmailNotificationsEnabled()) {
            $this->dispatch(new SendMessageNotificationEmail($message));    
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            MessagePublished::class,
            'LibrosJB\Listeners\MessageEventListener@onMessageCreated'
        );
    }
}