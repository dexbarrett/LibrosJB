<?php

namespace LibrosJB\Jobs;

use LibrosJB\Message;
use LibrosJB\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageNotificationEmail extends Job implements SelfHandling, ShouldQueue
{
    protected $message;

    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailData = [
            'bookTitle' => $this->message->conversation->book->title,
            'messageContent' => $this->message->message,
            'conversationID' => $this->message->conversation_id
        ];
        
        $mailer->send('emails.new-message', $mailData, function($m) {
            $m->to($this->message->to->email, 'Sucker')
              ->subject('Has recibido un nuevo mensaje');
        });
    }
}
