<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\DiscountCoupon;
use App\Http\Requests\CreateDiscountCouponRequest;
use App\Http\Requests\UpdateDiscountCouponRequest;
use Illuminate\Http\Request;



class DiscountCouponController extends Controller {

	/**
	 * Display a listing of discountcoupon
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $discountcoupon = DiscountCoupon::all();

		return view('admin.discountcoupon.index', compact('discountcoupon'));
	}

	/**
	 * Show the form for creating a new discountcoupon
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.discountcoupon.create');
	}

	/**
	 * Store a newly created discountcoupon in storage.
	 *
     * @param CreateDiscountCouponRequest|Request $request
	 */
	public function store(CreateDiscountCouponRequest $request)
	{
	    
		DiscountCoupon::create($request->all());

		return redirect()->route(config('coreadmin.route').'.discountcoupon.index');
	}

	/**
	 * Show the form for editing the specified discountcoupon.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$discountcoupon = DiscountCoupon::find($id);
	    
	    
		return view('admin.discountcoupon.edit', compact('discountcoupon'));
	}

	/**
	 * Update the specified discountcoupon in storage.
     * @param UpdateDiscountCouponRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateDiscountCouponRequest $request)
	{
		$discountcoupon = DiscountCoupon::findOrFail($id);

        

		$discountcoupon->update($request->all());

		return redirect()->route(config('coreadmin.route').'.discountcoupon.index');
	}

	/**
	 * Remove the specified discountcoupon from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		DiscountCoupon::destroy($id);

		return redirect()->route(config('coreadmin.route').'.discountcoupon.index');
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
            DiscountCoupon::destroy($toDelete);
        } else {
            DiscountCoupon::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.discountcoupon.index');
    }

}
