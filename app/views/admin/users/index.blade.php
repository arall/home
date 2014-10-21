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
        <small>List</small>

        <!-- Actions -->
        <div class="pull-right">
            {{ HTML::link(action('AdminUsersController@getUser'), 'New', array('class' => 'btn btn-primary')); }}
        </div>
    </h2>
</div>

{{ Datatable::table()->addColumn('id', 'Username', 'Email', 'Actions')->setUrl(action('AdminUsersController@getData'))->render() }}

@stop
