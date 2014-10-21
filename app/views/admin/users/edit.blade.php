@extends("layouts.default")

@section('title')
@parent
:: Users
@stop

@section('content')

<div class="page-header">
    <h2>
        <!-- Title -->
        <span class="glyphicon glyphicon-user"></span>
        Users
        <small> @if($user) Edit @else New @endif</small>

        <!-- Actions -->
        <div class="pull-right">
            {{ HTML::link(action('AdminUsersController@getUsers'), 'Cancel', array('class' => 'btn btn-primary')); }}
        </div>
    </h2>
</div>

{{ Form::model($user, array('action' => 'AdminUsersController@postUser', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ Form::hidden('id', $user->id) }}

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Account details
                </div>
                <div class="panel-body">

                    <!-- Status -->
                    {{ Form::switchField('status', 'Status', 1, $user->id ? $user->status : true) }}

                    <!-- Confirmed -->
                    {{ Form::switchField('confirmed', 'Confirmed', 1, $user->id ? $user->confirmed : true) }}

                    <!-- Username -->
                    {{ Form::textField('username', 'Username') }}

                    <!-- Email -->
                    {{ Form::textField('email', 'Email') }}

                    <!-- New Password -->
                    {{ Form::passwordField('password', 'New password') }}

                    <!-- Confirm Password -->
                    {{ Form::passwordField('password_confirmation', 'Confirm password') }}

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
