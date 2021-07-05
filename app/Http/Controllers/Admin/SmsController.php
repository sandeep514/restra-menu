<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Sms;
use App\Http\Requests\CreateSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Orders;
use App\SmsTemplate;


class SmsController extends Controller {

	/**
	 * Display a listing of sms
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $sms = Sms::with("orders")->with("smstemplate")->get();

		return view('admin.sms.index', compact('sms'));
	}

	/**
	 * Show the form for creating a new sms
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $orders = Orders::pluck("id", "id")->prepend('Please select', 0);
		$smstemplate = SmsTemplate::pluck("template_name", "id")->prepend('Please select', 0);

	    return view('admin.sms.create', compact("orders", "smstemplate"));
	}

	/**
	 * Store a newly created sms in storage.
	 *
     * @param CreateSmsRequest|Request $request
	 */
	public function store(CreateSmsRequest $request)
	{
	    $client = new Client();
        $endPoint = 'http://sms.zipzap.in/pushsms.php';
        $response = $client->request('GET', $endPoint, ['query' => [
            'username' => 'cleanfold',
            'api_password' => '32599yi0i8no6ctfk',
            'sender' => 'CLNFLD',
            'to' => $request->mobile_number,
            'message' => $request->message,
            'priority' => 11
        ]]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
		Sms::create($request->all());

		return redirect()->route(config('coreadmin.route').'.sms.index');
	}

	/**
	 * Show the form for editing the specified sms.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$sms = Sms::find($id);
	    $orders = Orders::pluck("number", "id")->prepend('Please select', 0);
$smstemplate = SmsTemplate::pluck("template_name", "id")->prepend('Please select', 0);


		return view('admin.sms.edit', compact('sms', "orders", "smstemplate"));
	}

	/**
	 * Update the specified sms in storage.
     * @param UpdateSmsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateSmsRequest $request)
	{
		$sms = Sms::findOrFail($id);



		$sms->update($request->all());

		return redirect()->route(config('coreadmin.route').'.sms.index');
	}

	/**
	 * Remove the specified sms from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Sms::destroy($id);

		return redirect()->route(config('coreadmin.route').'.sms.index');
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
            Sms::destroy($toDelete);
        } else {
            Sms::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.sms.index');
    }

}
