<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\ProductTypes;
use App\Http\Requests\CreateProductTypesRequest;
use App\Http\Requests\UpdateProductTypesRequest;
use Illuminate\Http\Request;
use App\Categories;



class ProductTypesController extends Controller {

	/**
	 * Display a listing of producttypes
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $producttypes = ProductTypes::all();

		return view('admin.producttypes.index', compact('producttypes'));
	}

	/**
	 * Show the form for creating a new producttypes
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
		
	    return view('admin.producttypes.create');
	}

	/**
	 * Store a newly created producttypes in storage.
	 *
     * @param CreateProductTypesRequest|Request $request
	 */
	public function store(CreateProductTypesRequest $request)
	{
	    if($request->hasFile('type_icon')){
	    	$fileName = $request->file('type_icon')->getClientOriginalName();
	    	$extension = $request->file('type_icon')->getClientOriginalExtension();
	    	$fileName = str_random().'_icon'.'.'.$extension;
	    	$destination = 'product_type_icons';
	    	$request->file('type_icon')->move($destination,$fileName);
	    }
	    $productTypes = new ProductTypes;
	    $productTypes->type_icon = $fileName;
		$productTypes->fill($request->except(['type_icon']));
		$productTypes->save();

		return redirect()->route(config('coreadmin.route').'.producttypes.index');
	}

	/**
	 * Show the form for editing the specified producttypes.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$producttypes = ProductTypes::find($id);
	    
	    
		return view('admin.producttypes.edit', compact('producttypes'));
	}

	/**
	 * Update the specified producttypes in storage.
     * @param UpdateProductTypesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateProductTypesRequest $request)
	{
		$producttypes = ProductTypes::findOrFail($id);

        if($request->hasFile('type_icon')){
	    	$fileName = $request->file('type_icon')->getClientOriginalName();
	    	$extension = $request->file('type_icon')->getClientOriginalExtension();
	    	$fileName = str_random().'_icon'.'.'.$extension;
	    	$destination = 'product_type_icons';
	    	$request->file('type_icon')->move($destination,$fileName);
	    	$producttypes->type_icon = $fileName;
	    }
	    
		$producttypes->fill($request->except(['type_icon']));
		$producttypes->save();

		return redirect()->route(config('coreadmin.route').'.producttypes.index');
	}

	/**
	 * Remove the specified producttypes from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		ProductTypes::destroy($id);

		return redirect()->route(config('coreadmin.route').'.producttypes.index');
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
            ProductTypes::destroy($toDelete);
        } else {
            ProductTypes::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.producttypes.index');
    }

    public function getProductTypes(Request $request, $category_id){
    	$categories = Categories::find($category_id);
    	$productTypes = json_decode($categories->product_types);
    	$productTypes = ProductTypes::whereIn('id',$productTypes)->pluck('type_name','id');
    	return response()->json(['product_type'=>$productTypes]);
    }

}
