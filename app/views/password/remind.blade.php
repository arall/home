@extends('layouts.default')

@section('title')
@parent
:: Account recovery
@stop

@section('content')

<div class="page-header">
    <h2>Account recovery</h2>
</div>

{{ Form::open(array('action' => 'RemindersController@postRemind', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Email confirmation
                </div>
                <div class="panel-body">

                    <!-- Email -->
                    {{ Form::textField('email', 'Email') }}

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit('Send recovery', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{ Form::close() }}
@stop
