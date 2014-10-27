@extends("layouts.default")

@section("content")

<div class="row">
    <!-- Add -->
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-plus"></span>
                Add items
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => 'storages.operate', 'class' => 'form-horizontal', 'role' => 'form')) }}

                    <!-- Storage -->
                    {{ Form::selectField('storageId', 'Storage', Storage::mine()->lists('name', 'id'), null, array('class' => 'form-control select2')) }}

                    <!-- Item -->
                    {{ Form::selectField('itemId', 'Item', Item::lists('name', 'id'), null, array('class' => 'form-control select2')) }}

                    <!-- Units -->
                    <div class="form-group">
                        {{ Form::label('quantity', 'Units', array('class' => 'col-sm-4 control-label')); }}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="1" value="1">
                                <span class="input-group-addon">U.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Price -->
                    <div class="form-group">
                        {{ Form::label('price', 'Total price', array('class' => 'col-sm-4 control-label')); }}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="number" step="any" class="form-control" name="price" id="price" placeholder="0.00">
                                <span class="input-group-addon">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            {{ Form::submit('Add', array('class' => 'btn btn-success')) }}
                        </div>
                    </div>

                {{ Form::close() }}
           </div>
        </div>
    </div>

    <!-- Subtract -->
    <div class="col-md-4">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-minus"></span>
                Subtract items
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => 'storages.operate', 'class' => 'form-horizontal', 'role' => 'form')) }}

                    {{ Form::hidden('operation', 'subtract') }}

                    <!-- Storage -->
                    {{ Form::selectField('storageId', 'Storage', Storage::mine()->lists('name', 'id'), null, array('class' => 'form-control select2')) }}

                    <!-- Item -->
                    {{ Form::selectField('itemId', 'Item', Item::lists('name', 'id'), null, array('class' => 'form-control select2')) }}

                    <!-- Units -->
                    <div class="form-group">
                        {{ Form::label('quantity', 'Units', array('class' => 'col-sm-4 control-label')); }}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="1" value="1">
                                <span class="input-group-addon">U.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            {{ Form::submit('Subtract', array('class' => 'btn btn-danger')) }}
                        </div>
                    </div>

                {{ Form::close() }}
           </div>
        </div>
    </div>

    <!-- Crete Item -->
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-leaf"></span>
                Create Item
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => 'items.save', 'class' => 'form-horizontal', 'role' => 'form')) }}

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
                            {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>

                {{ Form::close() }}
           </div>
        </div>
    </div>
</div>

<script>
    $("#ingredients").select2({
        tags: true,
        tokenSeparators: [",", " "],
        multiple: true,
        ajax: {
            url: '{{ URL::route('ingredients.ajax') }}',
            dataType: "json",
            data: function (term, page) {
                return {
                    q: term
                };
            },
            results: function (data, page) {
                return {
                    results: data.ingredients
                };
            }
        },
        createSearchChoice : function (term) { return { id: term, name: term }; },
        formatResult: function (term) { return term.name; },
        formatSelection: function (term) { return term.name; },
    });
</script>

@stop
