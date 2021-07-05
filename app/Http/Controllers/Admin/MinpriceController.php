<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Minprice;
use App\Http\Requests\CreateMinpriceRequest;
use App\Http\Requests\UpdateMinpriceRequest;
use Illuminate\Http\Request;



class MinpriceController extends Controller {

	/**
	 * Display a listing of minprice
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $minprice = Minprice::all();

		return view('admin.minprice.index', compact('minprice'));
	}

	/**
	 * Show the form for creating a new minprice
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.minprice.create');
	}

	/**
	 * Store a newly created minprice in storage.
	 *
     * @param CreateMinpriceRequest|Request $request
	 */
	public function store(CreateMinpriceRequest $request)
	{
	    
		Minprice::create($request->all());

		return redirect()->route(config('coreadmin.route').'.minprice.index');
	}

	/**
	 * Show the form for editing the specified minprice.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$minprice = Minprice::find($id);
	    
	    
		return view('admin.minprice.edit', compact('minprice'));
	}

	/**
	 * Update the specified minprice in storage.
     * @param UpdateMinpriceRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateMinpriceRequest $request)
	{
		$minprice = Minprice::findOrFail($id);

        

		$minprice->update($request->all());

		return redirect()->route(config('coreadmin.route').'.minprice.index');
	}

	/**
	 * Remove the specified minprice from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Minprice::destroy($id);

		return redirect()->route(config('coreadmin.route').'.minprice.index');
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
            Minprice::destroy($toDelete);
        } else {
            Minprice::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.minprice.index');
    }

}
