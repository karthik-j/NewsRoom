@extends('layouts.default')

@section('content')

<header>
    {{ Form::open(array('method' => 'GET')) }}
    <div class="input-group">
        {{ Form::text('q', Input::get('q'), array('class' => 'form-control input-lg', 'placeholder' => 'Enter your search term')) }}        
        <span class="input-group-btn">
            {{ Form::submit('Search', array('class' => 'btn btn-primary btn-lg')) }}            
        </span>
    </div>
    {{ Form::close() }}
</header>

@endsection