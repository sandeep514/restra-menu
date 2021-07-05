<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Categories;
use App\Http\Requests\CreateCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use App\ProductTypes;


class CategoriesController extends Controller {

	/**
	 * Display a listing of categories
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $categories = Categories::all();

		return view('admin.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new categories
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
		$productTypes = ProductTypes::pluck('type_name','id');
	    return view('admin.categories.create',['product_types'=>$productTypes]);
	}

	/**
	 * Store a newly created categories in storage.
	 *
     * @param CreateCategoriesRequest|Request $request
	 */
	public function store(CreateCategoriesRequest $request)
	{
	    $categories = new Categories;
	    $categories->product_types = json_encode($request->product_types);
		$categories->fill($request->except(['product_types']));
		$categories->save();

		return redirect()->route(config('coreadmin.route').'.categories.index');
	}

	/**
	 * Show the form for editing the specified categories.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$categories = Categories::find($id);
	    $productTypes = ProductTypes::pluck('type_name','id');
	    $categories->product_types = json_decode($categories->product_types);
		return view('admin.categories.edit', compact('categories','productTypes'));
	}

	/**
	 * Update the specified categories in storage.
     * @param UpdateCategoriesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateCategoriesRequest $request)
	{
		$categories = Categories::findOrFail($id);
		$categories->product_types = json_encode($request->product_types);
		$categories->update($request->except(['product_types']));

		return redirect()->route(config('coreadmin.route').'.categories.index');
	}

	/**
	 * Remove the specified categories from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Categories::destroy($id);

		return redirect()->route(config('coreadmin.route').'.categories.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Categories::destroy($toDelete);
        } else {
            Categories::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.categories.index');
    }

}
