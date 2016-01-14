<?php

namespace LibrosJB\Http\Middleware;

use Closure;
use LibrosJB\MessageManager;

class ClearUnreadMessages
{
    protected $messageManager;

    public function __construct(MessageManager $MessageManager)
    {
        $this->messageManager = $MessageManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! is_null(request()->route('conversationID'))) {
            $this->messageManager->clearUnreadMessagesForUser(
                request()->route('conversationID')
            );
        }

        return $response;
    }
}
