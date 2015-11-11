@if(session()->has('flash-message'))
    <div class="alert alert-{{ session()->get('type', 'info') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </button>
        <span class="text-center">{{ session()->get('flash-message') }}</span>
    </div>
@endif