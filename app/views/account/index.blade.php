@extends('layouts.default')

@section('title')
@parent
:: Account
@stop

@section('content')

<div class="page-header">
    <h2>Account</h2>
</div>

{{ Form::model($user, array('action' => 'AccountController@postAccount', 'class' => 'form-horizontal', 'role' => 'form')) }}

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

                    <!-- New Password -->
                    {{ Form::passwordField('password', 'Password') }}

                    <!-- Confirm new Password -->
                    {{ Form::passwordField('password_confirmation', 'Confirm') }}

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{ Form::close() }}
@stop
