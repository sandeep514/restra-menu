<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\SmsTemplate;
use App\Http\Requests\CreateSmsTemplateRequest;
use App\Http\Requests\UpdateSmsTemplateRequest;
use Illuminate\Http\Request;



class SmsTemplateController extends Controller {

	/**
	 * Display a listing of smstemplate
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $smstemplate = SmsTemplate::all();

		return view('admin.smstemplate.index', compact('smstemplate'));
	}

	/**
	 * Show the form for creating a new smstemplate
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{


	    return view('admin.smstemplate.create');
	}

	/**
	 * Store a newly created smstemplate in storage.
	 *
     * @param CreateSmsTemplateRequest|Request $request
	 */
	public function store(CreateSmsTemplateRequest $request)
	{

		SmsTemplate::create($request->all());

		return redirect()->route(config('coreadmin.route').'.smstemplate.index');
	}

	/**
	 * Show the form for editing the specified smstemplate.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$smstemplate = SmsTemplate::find($id);


		return view('admin.smstemplate.edit', compact('smstemplate'));
	}

	/**
	 * Update the specified smstemplate in storage.
     * @param UpdateSmsTemplateRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateSmsTemplateRequest $request)
	{
		$smstemplate = SmsTemplate::findOrFail($id);



		$smstemplate->update($request->all());

		return redirect()->route(config('coreadmin.route').'.smstemplate.index');
	}

	/**
	 * Remove the specified smstemplate from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		SmsTemplate::destroy($id);

		return redirect()->route(config('coreadmin.route').'.smstemplate.index');
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
            SmsTemplate::destroy($toDelete);
        } else {
            SmsTemplate::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.smstemplate.index');
    }

    public function getTemplateById($id){
    	$template = SmsTemplate::find($id);
    	return response()->json(['status'=>true,'data'=>$template->toArray()]);
    }

}
