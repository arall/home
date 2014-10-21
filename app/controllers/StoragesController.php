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
        $storages = Storage::all();

        return View::make('storages.index', compact('storages'));
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
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function datatables()
    {
        return Datatable::collection(Storage::all())
        ->showColumns('id')
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
        ->orderColumns('id', 'name', 'items', 'worth')
        ->make();
    }

}
