@extends('layouts.default')

@section('title')
@parent
:: Account recovery
@stop

@section('content')

<div class="page-header">
    <h2>Account recovery</h2>
</div>

{{ Form::open(array('action' => 'RemindersController@postReset', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ Form::hidden('token', $token) }}

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Password reset
                </div>
                <div class="panel-body">

                    <!-- Password -->
                    {{ Form::passwordField('password', 'New Password') }}

                    <!-- Confirm password -->
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
