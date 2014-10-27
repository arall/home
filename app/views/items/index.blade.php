@extends("layouts.default")

@section('title')
@parent
:: My items
@stop

@section('content')

<div class="page-header">
    <h2>
        <!-- Title -->
        <span class="glyphicon glyphicon-leaf"></span>
        My items
    </h2>
</div>

{{ Datatable::table()->addColumn('Name', 'Units', 'Worth')->setUrl(route('items.datatables'))->render() }}

@stop
