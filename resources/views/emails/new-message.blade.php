<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div style="font-family:Verdana, Arial;">Has recibido un nuevo mensaje sobre el libro <strong>{{ ucwords($bookTitle) }}</strong>:</div>
        <br>
        <div style="font-family:Verdana, Arial;"><i>{!! nl2br($messageContent) !!}</i></div>
        <br>
        <br>
        <br>
            <div style="font-family:Verdana, Arial;">
                Puedes responder a este mensaje <a href="{{ action('MessagesController@showConversation', ['conversationID' => $conversationID]) }}">aquí</a>
            </div>
    </body>
</html>