<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
        public function rules(): array
        {
            return [
                    'name' => 'required|unique:devices',
                    'quantity' => 'required',
                    'image' => 'required',
            ];
        }
        public function messages()
        {

            return [
                'name.required' => 'Bạn không được để trống !',
                'quantity.required' => 'Bạn không được để trống !',
                'image.required' => 'Bạn không được để trống !',
                'name.unique' => 'Tên thiết bị đã tồn tại !',
            ];
        }
}
