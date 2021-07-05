<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Products;
use App\Http\Requests\CreateProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use Illuminate\Http\Request;
use App\ProductTypes;
use App\Categories;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
class ProductsController extends Controller {

	/**
	 * Display a listing of products
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $products = Products::with("categories")->get();
		return view('admin.products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new products
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $categories = Categories::pluck("name", "id")->prepend('Please select', 0);

	    return view('admin.products.create', compact("categories"));
	}

	/**
	 * Store a newly created products in storage.
	 *
     * @param CreateProductsRequest|Request $request
	 */
	public function store(CreateProductsRequest $request)
	{
	    $name = '';
	    if($request->hasFile('image')){
	    	$name = $request->file('image')->getClientOriginalName();
	    	$request->file('image')->move(public_path('product_images'),$name);
	    }
	    $model = new Products;
	    $model->fill($request->all());
        // dd($model);
	    $model->image = $name;
	    $model->save();


		return redirect()->route(config('coreadmin.route').'.products.index');
	}

	/**
	 * Show the form for editing the specified products.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$products = Products::find($id);
	    $categories = Categories::pluck("name", "id")->prepend('Please select', 0);
	    $selected_category = Categories::find($products->categories_id);
	    $productTypes = ProductTypes::whereIn('id',json_decode($selected_category->product_types,true))->pluck('type_name','id')->prepend('Please select',0);

		return view('admin.products.edit', compact('products', "categories",'productTypes'));
	}

	/**
	 * Update the specified products in storage.
     * @param UpdateProductsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateProductsRequest $request)
	{
		if($request->hasFile('image')){
	    	$name = $request->file('image')->getClientOriginalName();
	    	$request->file('image')->move(public_path('product_images'),$name);
	    }
		$products = Products::findOrFail($id);
		if($request->hasFile('image')){
		    $products->image = $name;
		}
		$products->update($request->all());

		return redirect()->route(config('coreadmin.route').'.products.index');
	}

	/**
	 * Remove the specified products from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Products::destroy($id);

		return redirect()->route(config('coreadmin.route').'.products.index');
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
            Products::destroy($toDelete);
        } else {
            Products::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.products.index');
    }


    public function export()
    {
        // return Excel::download(new ProductsExport, 'users.xlsx');
        return Excel::download(new ProductsExport(), 'export.xlsx');

    }

    public function import(Request $request)
    {

        Excel::import(new ProductsImport,request()->file('file'));

        return back()->with('success', 'All good!');
    }

    public function importExportView()
    {
       return view('import');
    }

    public function bulk(request $request)
    {

     $bulk= new Products;
     $bulk->where('id',"!=",null)->update(['discount_product'=>$request->discount_product]);

     return back();
    //  $bulk->discount_percentage=$request->discount_percentage;
    //  $bulk->save();
    //  return back();


    }



}




