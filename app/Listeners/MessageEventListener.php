<?php
namespace LibrosJB\Listeners;

use LibrosJB\MessageManager;
use LibrosJB\ConversationInfo;
use Illuminate\Contracts\Mail\Mailer;
use LibrosJB\Events\MessagePublished;

class MessageEventListener
{
    protected $MessageManager;
    protected $mailer;

    public function __construct(MessageManager $MessageManager, Mailer $mailer)
    {
        $this->MessageManager = $MessageManager;
        $this->mailer = $mailer;
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


        $mailData = [
            'bookTitle' => $message->conversation->book->title,
            'messageContent' => $message->message,
            'conversationID' => $message->conversation_id
        ];
        $this->mailer->send('emails.new-message', $mailData, function($m) use($message){
            $m->to($message->to->email, 'Sucker')
              ->subject('Has recibido un nuevo mensaje');
        });

    }

    public function subscribe($events)
    {
        $events->listen(
            MessagePublished::class,
            'LibrosJB\Listeners\MessageEventListener@onMessageCreated'
        );
    }
}