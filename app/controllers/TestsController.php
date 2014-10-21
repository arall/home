<?php

class TestsController extends \BaseController {

	/**
	 * Display a listing of tests
	 *
	 * @return Response
	 */
	public function index()
	{
		$tests = Test::all();

		return View::make('tests.index', compact('tests'));
	}

	/**
	 * Show the form for creating a new test
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tests.create');
	}

	/**
	 * Store a newly created test in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Test::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Test::create($data);

		return Redirect::route('tests.index');
	}

	/**
	 * Display the specified test.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$test = Test::findOrFail($id);

		return View::make('tests.show', compact('test'));
	}

	/**
	 * Show the form for editing the specified test.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$test = Test::find($id);

		return View::make('tests.edit', compact('test'));
	}

	/**
	 * Update the specified test in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$test = Test::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Test::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$test->update($data);

		return Redirect::route('tests.index');
	}

	/**
	 * Remove the specified test from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Test::destroy($id);

		return Redirect::route('tests.index');
	}

}
