@extends("layouts.default")

@section('title')
@parent
:: My storages
@stop

@section('content')

<div class="page-header">
    <h2>
        <!-- Title -->
        <span class="glyphicon glyphicon-inbox"></span>
        My storages

        <!-- Actions -->
        <div class="pull-right">
            {{ HTML::link(route('storages.new'), 'New', array('class' => 'btn btn-primary')); }}
        </div>
    </h2>
</div>

{{ Datatable::table()->addColumn('Name', 'Items', 'Worth')->setUrl(route('storages.datatables'))->render() }}

@stop
