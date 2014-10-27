<?php

class IngredientsController extends \BaseController
{
    /**
     * Ajax
     *
     * @return Response
     */
    public function ajax()
    {
        // Query
        $query = Ingredient::select('id', 'name')->orderBy('name', 'asc');

        // Name filter
        if (Input::get('q')) {
            $query->where('name', 'like', '%'.Input::get('q').'%');
        }

        // Models
        $ingredients = $query->take(10)->get();

        // View
        return Response::json(array('success' => true, 'ingredients' => $ingredients));
    }

}
