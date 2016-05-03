@extends('layouts.master')
@section('page-content')
<div class="row">
    <h1 class="text-center error-page">Whoops!</h2>
    <h2 class="text-center">
        @yield('error-message')
    </h2>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <img class="img-responsive" src="/images/book-tunnel.png" alt="">
    </div>
</div>
@stop