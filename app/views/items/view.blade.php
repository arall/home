@extends("layouts.default")

@section('title')
@parent
:: Item
@stop

@section('content')

<div class="page-header">
    <h2>
        <!-- Title -->
        <span class="glyphicon glyphicon-inbox"></span>
        {{{ isset($item->id) ? $item->name : 'New item' }}}

        <!-- Actions -->
        <div class="pull-right">
            @if (isset($item->id)) {{ HTML::link(route('items.delete', $item->id), 'Delete', array('class' => 'btn btn-danger')); }}
            @endif
        </div>
    </h2>
</div>

{{ Form::model($item, array('route' => 'items.save', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ isset($item->id) ? Form::hidden('id', $item->id) : '' }}

    <div class="row">
        <!-- Edit -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Item details
                </div>
                <div class="panel-body">

                    <!-- Type -->
                    {{ Form::selectField('type_id', 'Type', ItemType::lists('name', 'id'), null, array('class' => 'form-control select2')) }}

                    <!-- Name -->
                    {{ Form::textField('name', 'Name', null, array('class' => 'form-control')) }}

                    <!-- Barcode -->
                    {{ Form::textField('barcode', 'Barcode', null, array('class' => 'form-control')) }}

                    <!-- Ingredients -->
                    {{ Form::textField('ingredients', 'Ingredients', null, array('class' => 'form-control', 'id' => 'ingredients')) }}

                    <!-- Quantity -->
                    <div class="form-group">
                        {{ Form::label('quantity', 'Quantity', array('class' => 'col-sm-4 control-label')); }}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="10" value="">
                                <span class="input-group-addon">mg. / ml.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kcal -->
                    <div class="form-group">
                        {{ Form::label('kcal', 'KCalories', array('class' => 'col-sm-4 control-label')); }}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="kcal" id="kcal" placeholder="130" value="">
                                <span class="input-group-addon">Kcal</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
               </div>
            </div>
        </div>

        @if (isset($item->id))
            <!-- Current storages -->
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current storages
                    </div>
                    <div class="panel-body">
                        @if ($item->currentStorages)
                            <table class="table table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Storage</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->currentStorages as $stogare)
                                        <tr>
                                            <td>{{{ $stogare->name }}}</td>
                                            <td>{{{ $stogare->total }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote>
                                <p>This item is not in any storage</p>
                            </blockquote>
                        @endif
                   </div>
                </div>
            </div>
            <!-- Item history -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Item history
                    </div>
                    <div class="panel-body">
                        @if ($item->storages()->mine()->count())
                            <table class="table table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Storage</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($item->storages()->mine()->get() as $storage)
                                        <tr>
                                            <td>{{{ $storage->name }}}</td>
                                            <td>{{{ $storage->pivot->quantity }}}</td>
                                            <td>{{{ $storage->pivot->price }}}</td>
                                            <td>{{{ $storage->pivot->created_at }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote>
                                <p>This item doesn't has a storage history</p>
                            </blockquote>
                        @endif
                   </div>
                </div>
            </div>
        @endif
    </div>

{{ Form::close() }}

@stop
