@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" id="reservation">
            <reservation :user="{{ Auth::user() }}"> </reservation> 
        </div>
    </div>
</div>
@endsection
