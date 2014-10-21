@extends('layouts.default')

@section('title')
@parent
:: Login
@stop

@section('content')

<div class="wrapper login">

    {{ Form::open(array('route' => 'login.do', 'class' => 'form-login')) }}

        <h2 class="form-login-heading">Please login</h2>

        {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'required' => true, 'autofocus' => true)) }}
        {{ Form::password('password', array('class' => 'form-control', 'required' => true)) }}

        <label class="remember">
            {{ Form::checkbox('remember', 1); }} Remember me
        </label>

        {{ Form::submit('Sing In', array('class' => 'btn btn-primary btn-block')) }}

        <p class="text-center recovery">
            {{ HTML::link(action('RemindersController@getRemind'), 'Lost your password?') }}
        </p>

    {{ Form::close() }}

</div>

@stop
