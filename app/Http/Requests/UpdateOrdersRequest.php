<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrdersRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'amount' => 'required',
            'status' => 'required',
            'payment_status' => 'required',
            'pickup_status' => 'required',
            'pickup_time' => 'required',
            'delv_time' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'user_id' => 'required',
            'category' => 'required',
            'product' => 'required',


		];
	}
}
