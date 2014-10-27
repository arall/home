<?php

class StoragesController extends \BaseController
{
    /**
     * Display a listing of storages
     *
     * @return Response
     */
    public function index()
    {
        return View::make('storages.index');
    }

    /**
     * Show the form for creating a new storage
     *
     * @return Response
     */
    public function create()
    {
        return View::make('storages.create');
    }

    /**
     * Add / Subtract an item from a storage
     *
     * @return Response
     */
    public function operate()
    {
        // Storage
        $storage = Storage::findOrFail(Input::get('storageId'));
        // Item
        $item = Item::findOrFail(Input::get('itemId'));
        // Quantity
        $quantity = Input::get('quantity');
        // Price
        $price = Input::get('price');
        // Operation
        $operation = Input::get('operation', 'add');

        // Own?
        if ($storage->user_id == Auth::user()->id) {
            // (Subtract) Storage has that items?
            $total = $storage->items()->where('items.id', $item->id)->sum('item_storage.quantity');
            if ($operation == 'add' || $total >= $quantity) {
                // Add / Subtract
                if ($operation == 'subtract') {
                    // Negative quantity
                    $quantity = -1 * abs($quantity);
                    // Negative price (auto-calc)
                    $price = -1 * ($item->getUnityPrice(Auth::user()->id) * abs($quantity));
                }
                $storage->items()->attach($item->id, array('quantity' => $quantity, 'price' => $price));
                // Message
                if ($operation == 'subtract') {
                    Flash::success('Items subtracted!');
                } else {
                    Flash::success('Items added!');
                }
            } else {
                // Message
                Flash::error("Storage '".$storage->name."' doest' contain ".$quantity." '".$item->name."', just ".$total.".");
            }
        } else {
            // Message
            Flash::error('Storage not found');
        }

        return Redirect::to('/');
    }

    /**
     * Show the form for editing the specified storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id = null)
    {
        if ($id) {
            $storage = Storage::find($id);
            // Own?
            if ($storage->user_id != Auth::user()->id) {
                // Message
                Flash::error('Storage not found');

                return Redirect::route('storages.index');
            }
        } else {
            $storage = new Storage();
        }

        return View::make('storages.view', compact('storage'));
    }

    /**
     * Create/Update the specified storage in storage.
     *
     * @return Response
     */
    public function save()
    {
        if ($id = Input::get('id')) {
            $storage = Storage::find($id);
        }

        // Validation
        $validator = Validator::make($data = Input::all(), Storage::$rules);

        // Check if the form validates with success.
        if ($validator->passes()) {
            // Own?
            if (isset($storage) && $storage->user_id == Auth::user()->id) {
                // Save model
                $storage->update($data);
                // Message
                Flash::success('Storage saved successfully');
            } else {
                // Create model
                $storage = new Storage($data);
                // Asociate to current user
                Auth::user()->storages()->save($storage);
                // Message
                Flash::success('Storage created successfully');
            }

            // Redirect to resource list
            return Redirect::route('storages.index');
        }

        // Something went wrong
        return Redirect::back()->withErrors($validator)->withInput(Input::all());
    }

    /**
     * Remove the specified storage from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function delete($id)
    {
        $storage = Storage::find($id);
        // Own?
        if ($storage->user_id == Auth::user()->id) {
            $storage->delete();
            // Message
            Flash::success('Storage deleted successfully');
        } else {
            // Message
            Flash::error('Storage not found');
        }

        return Redirect::route('storages.index');
    }

    /**
     * Show a list of all the storages formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function datatables()
    {
        return Datatable::collection(Storage::mine()->get())

        ->addColumn('name',function ($model) {
            return HTML::link(route('storages.view', $model->id), $model->name);
        })
        ->addColumn('items',function ($model) {
            return $model->itemsCount;
        })
        ->addColumn('worth',function ($model) {
            return $model->itemsWorth." €";
        })
        ->searchColumns('name')
        ->orderColumns('name', 'items', 'worth')
        ->make();
    }

}
