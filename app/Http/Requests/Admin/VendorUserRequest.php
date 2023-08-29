<?php
    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Request;

    class VendorUserRequest extends FormRequest
    {
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
         * @return array<string, mixed>
         */
        public function rules()
        {
            if($this->method() == 'POST')
            {
                $rules = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255','unique:users'],
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:9', 'max:14','unique:users'],
                    'password' => ['required','string','min:6','confirmed'],
                    'vendor_id' => ['required', 'numeric'],
                    'role_id' => ['required', 'numeric']
                ];
            }

            if($this->method() == 'PATCH')
            {
                $id = Request::segment(4);
                $rules = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255','unique:users,email,' . $id],
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:9', 'max:14','unique:users,phone,' . $id],
                ];

                if(request()->has('type') && request('type') != 'vendor')
                {
                    $rules['vendor_id'] = ['required', 'numeric'];
                    $rules['role_id'] = ['required', 'numeric'];
                }

                if(request()->has('password') && request('password') != '')
                {
                    $rules['password'] = ['string','min:6','confirmed'];
                }
            }
            return $rules;
        }
    }
