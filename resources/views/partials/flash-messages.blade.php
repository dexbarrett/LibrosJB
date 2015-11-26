@if(session()->has('message'))
    <div class="alert alert-{{ session()->get('message-type', 'info') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <p class="text-center">{{ session()->get('message') }}</p>
    </div>
@endif