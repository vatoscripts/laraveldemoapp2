<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // Check if Bulk Registration rules Page 1
        if ($this->is('bulk-registration-NIDA')) {
            return $this->bulkRegRules_page1();
        }
        // Check if Bulk Registration rules Page 2
        elseif ($this->is('bulk-registration-save')) {
            return $this->bulkRegRules_page2();
        }
    }

    private function bulkRegRules_page1()
    {
        return [
            'spocEmail' => 'required|email',
            'spocMsisdn' => 'required|regex:/^\+?(255)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required',
            'region' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'village' => 'required',
            //'expiry-date' => 'required',
        ];
    }

    private function bulkRegRules_page2()
    {
        return [
            'business-name' => 'required|string',
            'MSISDN-file' => 'required|mimes:csv,txt',
            'company-email' => 'required|email',
            'registrationCategory' => 'required',
            'machine2machine' => 'required',
            'TIN' => 'required_if:registrationCategory,COMP,CEMP',
            'TIN-file' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'business-licence-file' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'business-licence' => 'required_if:registrationCategory,COMP,CEMP',
            'BRELA-file' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'spoc-attachment-file' => 'required_if:registrationCategory,INST|mimes:jpeg,jpg,png|max:200',
        ];
    }

    public function messages()
    {
        return [
            /** BULK REGISTRATION Page1 **/
            'spocEmail.required' => 'Please Input SPOC\'s email adress !',
            'spocEmail.email' => 'Invalid SPOC\'s email adress !',
            'spocMsisdn.required' => 'Please Input SPOC\'s phone number !',
            'spocMsisdn.email' => 'Invalid SPOC\'s phone number !',
            'NIN.required' => 'Please Input SPOC\'s NIDA ID !',
            'NIN.digits' => 'Invalid SPOC\'s NIDA ID Format !',
            'fingerCode.required' => 'Please Select SPOC\'s finger index !',
            'fingerData.required' => 'Please Capture SPOC\'s finger print !',
            'phoneNumber.required' => 'Please Input SPOC\'s phone number!',
            'phoneNumber.digits' => 'Invalid SPOC\'s phone number !',
            'phoneNumber.regex' => 'Invalid SPOC\'s phone number !',
            'region.required' => 'Please Select region !',
            'district.required' => 'Please Select district !',
            'ward.required' => 'Please Select ward !',
            'village.required' => 'Please Select street !',
            'expiry-date.required' => 'Please Input Expiry Date !',

            /** BULK REGISTRATION Page2 **/
            'business-name.required' => 'Please Input Business or Company name !',
            'spoc-attachment-file.required_if' => 'Please Input Company\'s SPOC attachment file !',
            'MSISDN-file.mimes' => 'Company\'s phone numbers file must be in CSV format !',
            'MSISDN-file.required' => 'Please Input Company\'s phone numbers file !',
            'spoc-attachment-file.mimes' => 'Company\'s SPOC attachment must be in PNG, JPG or JPEG format !',
            'spoc-attachment-file.max' => 'Introduction Letter attachment Max file Size of 200KB Exceeded !',
            'company-email.required' => 'Please Input Company\'s E-mail Adress !',
            'company-email.email' => 'Invalid Company\'s E-mail Adress format !',

            'TIN.required_if' => 'Please Input Company TIN number !',
            'TIN.numeric' => 'Invalid Company TIN number !',
            'TIN-file.required_if' => 'Please Input Company\'s SPOC attachment file !',
            'TIN-file.mimes' => 'TIN file must be in PNG, JPG or JPEG format !',
            'TIN-file.max' => 'TIN file Max Size of 200KB Exceeded !',
            'business-licence.required_if' => 'Please Input Company\'s Business Licence number !',
            'business-licence.numeric' => 'Invalid Business Licence number !',
            'business-licence-file.required_if' => 'Please Input Business Licence file !',
            'business-licence-file.mimes' => 'Business Licence file must be in PNG, JPG or JPEG format !',
            'business-licence-file.max' => 'Business Licence file Max Size of 200KB  Exceeded !',
            'BRELA-file.required_if' => 'Please Input Certificate of Incorporation (BRELA) file !',
            'BRELA-file.mimes' => 'BRELA file must be in PNG, JPG or JPEG format !',
            'BRELA-file.max' => 'BRELA file Max  Size of 200KB Exceeded !',
            'registrationCategory.required' => 'Please Input Registration category !',
            'machine2machine.required' => 'Please select if is Machine-to-Machine registration !'
        ];
    }

}
