@extends('layouts.master')
@section('page-title', 'Mensajes para libro')
@section('navbar-content')
<ul class="nav navbar-nav navbar-right">
    <li>
        <a  id="new-message" href="#" class="btn btn-warning navbar-link" data-toggle="modal" data-target="#message-box">Nuevo mensaje</a>
    </li>
</ul>
@stop
@section('page-content')
<div class="row">
    <div class="messages">
        @foreach($conversation->messages as $message)
            <div class="row message">
                <div class="col-md-6 column">
                    <div class="alert" data-user-id="{{ $message->from_user }}">
                            {!! nl2br($message->message) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- modal box start -->
<div id="message-box" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Escribe aquí tu mensaje</h4>
      </div>
          {!! Form::open(['action' => ['MessagesController@createMessage', $conversation->id]]) !!}
          <div class="modal-body">
            <div class="form-group">
                <textarea id="message-content" name="message-content" cols="30" rows="10" class="form-control"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <input id="publish" type="submit" class="btn btn-success btn-md" value="Publicar" disabled>
          </div>
      {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- modal box end -->
@stop
@section('custom-scripts')
<script>
    submitButton = $('#publish');
    var ownId = {{ auth()->user()->id }}
    var messages = $('div.messages');
    var ownMessages = messages.find('.alert[data-user-id=' + ownId + ']');

    ownMessages.addClass('alert-info').closest('div.column')
        .addClass('col-md-offset-1');
    messages.find('.alert').not(ownMessages).addClass('alert-danger')
        .closest('div.column').addClass('col-md-offset-2');

    $('#message-box').on('hidden.bs.modal', function (e) {
        $(this).find('#message-content').val('');
        submitButton.prop('disabled', true);
    });

    $('#message-content').on('input', function(e){
        var disabled = ($(this).val().trim().length == 0);
        submitButton.prop('disabled', disabled);
        console.log(disabled);
    });
</script>
@stop