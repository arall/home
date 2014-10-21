@extends('layouts.default')

@section('title')
@parent
:: Register
@stop

@section('content')

<div class="page-header">
    <h2>Register</h2>
</div>

{{ Form::open(array('route' => 'register.do', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Account details
                </div>
                <div class="panel-body">
                    <!-- Username -->
                    {{ Form::textField('username', 'Username') }}

                    <!-- Email -->
                    {{ Form::textField('email', 'Email') }}

                    <!-- Password -->
                    {{ Form::passwordField('password', 'Password') }}

                    <!-- Confirm Password -->
                    {{ Form::passwordField('password_confirmation', 'Password Confirmation') }}

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit('Sing Up', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{ Form::close() }}
@stop
