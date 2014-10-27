<?php

class ItemsController extends \BaseController
{
    /**
     * Display a listing of items
     *
     * @return Response
     */
    public function index()
    {
        return View::make('items.index');
    }

    public function save()
    {
        if ($id = Input::get('id')) {
            $item = Item::find($id);
        }

        // Validation
        $validator = Validator::make($data = Input::all(), Item::$rules);

        // Check if the form validates with success.
        if ($validator->passes()) {
            if (isset($item)) {
                // Save model
                $item->update($data);
                // Message
                Flash::success('Item saved successfully');
            } else {
                // Create model
                $item = Item::create($data);
                // Message
                Flash::success('Item created successfully');
            }

            // Ingredients
            $ingredients = explode(',', Input::get('ingredients'));
            if (!empty($ingredients)) {
                $ingredientsIds = array();
                foreach ($ingredients as $name) {
                    $ingredient = Ingredient::firstOrCreate(['name' => $name]);
                    $ingredientsIds[] = $ingredient->id;
                }
                $item->ingredients()->sync($ingredientsIds);
            }

            // Redirect
            return Redirect::route('items.show', array('id' => $item->id));
        }

        // Something went wrong
        return Redirect::back()->withErrors($validator)->withInput(Input::all());
    }

    /**
     * Display the specified item.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return View::make('items.view', compact('item'));
    }

    /**
     * Remove the specified item.
     *
     * @param  int      $id
     * @return Response
     */
    public function delete($id)
    {
        $item = Item::find($id);
        $item->delete();

        // Message
        Flash::success('Item deleted successfully');

        return Redirect::route('storages.index');
    }

    /**
     * Show a list of all the items formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function datatables()
    {
        $items = DB::table('item_storage')
            ->select(DB::raw('sum(item_storage.quantity) as units, sum(item_storage.price) as worth, items.name, items.id'))
            ->leftJoin('items', 'items.id', '=', 'item_storage.item_id')
            ->leftJoin('storages', 'storages.id', '=', 'item_storage.storage_id')
            ->havingRaw('sum(item_storage.quantity) > 0')
            ->where('storages.user_id', Auth::user()->id)
            ->groupBy('items.id');

        return Datatable::query($items)

        ->addColumn('name',function ($model) {
            return HTML::link(route('items.view', $model->id), $model->name);
        })
        ->showColumns('units', 'worth')
        ->searchColumns('name')
        ->orderColumns('name', 'units', 'worth')
        ->make();
    }

}
