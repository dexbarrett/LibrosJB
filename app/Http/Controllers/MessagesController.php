<?php
namespace LibrosJB\Http\Controllers;

use LibrosJB\Book;
use LibrosJB\Message;
use LibrosJB\Conversation;
use LibrosJB\Http\Requests;
use Illuminate\Http\Request;
use LibrosJB\MessageManager;
use LibrosJB\ConversationInfo;
use Illuminate\Support\Facades\DB;
use LibrosJB\Events\MessagePublished;
use LibrosJB\Http\Controllers\Controller;

class MessagesController extends Controller
{
    protected $messageManager;

    public function __construct(MessageManager $messageManager)
    {
        $this->messageManager = $messageManager;
        parent::__construct();
    }

    public function listConversations()
    {

        $conversations = $this->messageManager
            ->getConversationsForUser($this->user->id);

        return view('books.conversations')
            ->with(compact('conversations'));
    }
    public function createConversation($bookID)
    {
        $book = Book::findOrFail($bookID);

        $conversation = Conversation::firstOrCreate([
            'book_id'   => $book->id,
            'from_user' => $this->user->id,
            'to_user'   => $book->user->id
        ]);

        return redirect()->action(
            'MessagesController@showConversation', ['conversationID' => $conversation->id]
        );
    }

    public function showConversation($conversationID)
    {
        $conversation = Conversation::with(['messages' => function($query){
            $query->orderBy('created_at');
        }])->findOrFail($conversationID);

        return view('books.messages')
            ->with(compact('conversation'));
    }

    public function createMessage($conversationID)
    {
        $conversation = Conversation::findOrFail($conversationID);

        $from = $this->user->id;
        $to = null;

        if ($conversation->book->isSoldBy($this->user->id)) {
            $to = $conversation->from_user;
        } else {
            $to = $conversation->to_user;
        }

        ConversationInfo::firstOrCreate([
            'conversation_id' => $conversation->id,
            'user_id'         => $this->user->id
        ]);

        ConversationInfo::firstOrCreate([
            'conversation_id' => $conversation->id,
            'user_id'         => $conversation->book->user_id
        ]);

        $messageContent = request()->input('message-content');
        $message = new Message([
            'from_user' => $from,
            'to_user' => $to,
            'message' => $messageContent
        ]);



        $conversation->messages()->save($message);

        event(new MessagePublished($message));

        return redirect()->action(
            'MessagesController@showConversation', ['conversationID' => $conversation->id]
        );

    }
}
