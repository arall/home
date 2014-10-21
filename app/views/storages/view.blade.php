@extends("layouts.default")

@section('title')
@parent
:: Storages
@stop

@section('content')

<div class="page-header">
    <h2>
        <!-- Title -->
        <span class="glyphicon glyphicon-inbox"></span>
        {{{ isset($storage->id) ? $storage->name : 'New storage' }}}

        <!-- Actions -->
        <div class="pull-right">
            @if (isset($storage->id)) {{ HTML::link(route('storages.delete', $storage->id), 'Delete', array('class' => 'btn btn-danger')); }}
            @endif
        </div>
    </h2>
</div>

{{ Form::model($storage, array('route' => 'storages.save', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ isset($storage->id) ? Form::hidden('id', $storage->id) : '' }}

    <div class="row">
        <!-- Edit -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Storage details
                </div>
                <div class="panel-body">

                    <!-- Name -->
                    {{ Form::textField('name', 'Name') }}

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
               </div>
            </div>
        </div>
        @if (isset($storage->id))
            <!-- Current items -->
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current items
                    </div>
                    <div class="panel-body">
                        @if ($storage->currentItems)
                            <table class="table table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($storage->currentItems as $item)
                                        <tr>
                                            <td>{{{ $item->name }}}</td>
                                            <td>{{{ $item->total }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote>
                                <p>This storage does not contain any item</p>
                            </blockquote>
                        @endif
                   </div>
                </div>
            </div>
            <!-- Items history -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Items history
                    </div>
                    <div class="panel-body">
                        @if ($storage->items)
                            <table class="table table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($storage->items as $item)
                                        <tr>
                                            <td>{{{ $item->name }}}</td>
                                            <td>{{{ $item->pivot->quantity }}}</td>
                                            <td>{{{ $item->pivot->price }}}</td>
                                            <td>{{{ $item->pivot->created_at }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote>
                                <p>This storage does has an item history</p>
                            </blockquote>
                        @endif
                   </div>
                </div>
            </div>
        @endif
    </div>

{{ Form::close() }}

@stop
