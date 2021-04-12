<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        // Check if NIDA rules i.e NIN, fingerData & fingerIndex
        if ($this->is('one-sim/new-reg-post') ) {
            return $this->NewRegStartRules();
        }

        // Check if New Minor rules
        elseif ($this->is('one-sim/new-reg-primary-post')) {
            return $this->NewRegPrimaryNIDARules();
        }

        // Check if New Minor rules
        elseif ($this->is('one-sim/new-reg-secondary-post')) {
            return $this->NewRegSecondaryNIDARules();
        }

        // // Check if New Diplomat rules
        // if ($this->is('one-sim/diplomat/new-reg-post') ) {
        //     return $this->NewDiplomatRegStartRules();
        // }

        // Check if Single Diplomat Primary rules
        if ($this->is('api/diplomat/register-primary') ) {
            return $this->diplomatPrimaryRules();
        }

        // Check if Single Diplomat Secondary rules
        if ($this->is('api/diplomat/register-secondary') ) {
            return $this->diplomatSecondaryRules();
        }

        // Check if New Visitor rules
        if ($this->is('api/visitor/check-msisdn') ) {
            return $this->NewVisitorRegStartRules();
        }

        // Check if Visitor Primary rules
        if ($this->is('api/visitor/register-primary') ) {
            return $this->NewVisitorRegPrimaryRules();
        }

        // Check if Visitor Secondary rules
        if ($this->is('api/visitor/register-secondary') ) {
            return $this->NewVisitorRegSecondaryRules();
        }

        // Check if Bulk rules
        if ($this->is('api/one-sim/bulk/new-reg-post') ) {
            return $this->NewBulkRegStartRules();
        }

        // Check if Bulk search rules
        if ($this->is('api/one-sim/bulk/new-reg-search') ) {
            return $this->NewBulkRegSearchRules();
        }

        // Check if Bulk primary spoc rules
        if ($this->is('api/one-sim/bulk/primary-spoc') ) {
            return $this->NewBulkRegPrimarySpocRules();
        }

        // Check if Bulk primary company rules
        if ($this->is('api/one-sim/bulk/primary-register') ) {
            return $this->NewBulkRegPrimaryCompanyRules();
        }

        // Check if Minor start rules
        if ($this->is('api/one-sim/minor/check-msisdn') ) {
            return $this->MinorCheckMsisdnRules();
        }

        // Check if Minor register rules
        if ($this->is('api/one-sim/minor/register') ) {
            return $this->MinorRegisterRules();
        }

        // Check if Set Primary start rules
        if ($this->is('api/primary/check-msisdn') || $this->is('api/secondary/check-msisdn') ) {
            return $this->setPrimaryStartRules();
        }

        // Check if Set Primary rules
        if ($this->is('api/primary/set-msisdn') ) {
            return $this->setPrimaryRules();
        }

        // Check if Set Secondary rules
        if ($this->is('api/secondary/set-msisdn') ) {
            return $this->setSecondaryRules();
        }

        // Check Bulk secondary search rules
        if ($this->is('api/one-sim/bulk/company-search') ) {
            return $this->bulkRegCompanySearchRules();
        }

        // Check if Bulk secondary spoc rules
        if ($this->is('api/one-sim/bulk/secondary-register') ) {
            return $this->bulkRegSecondaryRules();
        }

        // Check diplomat start rules
        if ($this->is('api/diplomat/check-msisdn') ) {
            return $this->diplomatStartRules();
        }

        // Check NIDA start rules
        if ($this->is('api/nida/check-msisdn') ) {
            return $this->NidaStartRules();
        }

        // Check NIDA start rules
        if ($this->is('api/nida/register-primary') ) {
            return $this->NidaPrimaryRules();
        }

        // Check NIDA start rules
        if ($this->is('api/nida/register-secondary') ) {
            return $this->NidaSecondaryRules();
        }

        // Check Bulk Declaration rules
        if ($this->is('api/one-sim/bulk/declaration') ) {
            return $this->BulkDeclarationRules();
        }

        // Check Dereg NIDA rules
        if ($this->is('api/dereg/nida') ) {
            return $this->DeregNIDAnRules();
        }

        // Check Dereg Msisdn rules
        if ($this->is('api/dereg/msisdn') ) {
            return $this->DeregMsisdnRules();
        }

        // Check Dereg Code rules
        if ($this->is('api/dereg/code') ) {
            return $this->DeregCodeRules();
        }
    }

    private function DeregNIDAnRules()
    {
        return [
            'msisdn' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function DeregMsisdnRules()
    {
        return [
            'deregMsisdn' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
        ];
    }

    private function DeregCodeRules()
    {
        return [
            'codeNumber' => 'required|digits:6',
            'deregReason' => 'required'
        ];
    }

    private function BulkDeclarationRules()
    {
        return [
            'spocMsisdn' => 'required|regex:/^(255)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
            'bulkTcraReason' => 'required',
            'msisdnFile' => 'required|mimes:csv,txt',
        ];
    }

    private function NidaStartRules()
    {
        return [
            'msisdn' => 'required|regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
        ];
    }

    private function NidaPrimaryRules()
    {
        return [
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function NidaSecondaryRules()
    {
        return [
            'fingerCode' => 'required',
            'fingerData' => 'required',
            'tcraReason' => 'required'
        ];
    }

    private function NewRegStartRules()
    {
        return [
            'msisdn' => 'required|regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
        ];
    }

    private function NewRegPrimaryNIDARules()
    {
        return [
            'fingerCode' => 'required',
            'fingerData' => 'required'
        ];
    }

    private function NewRegSecondaryNIDARules()
    {
        return [
            'fingerCode' => 'required',
            'fingerData' => 'required',
            'tcraReason' => 'required'
        ];
    }

    private function diplomatStartRules()
    {
        return [
            'msisdn' => 'required|regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
            'passportNumber' => 'required',
        ];
    }

    private function NewVisitorRegStartRules()
    {
        return [
            'msisdn' => 'required|regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
            'passportNumber' => 'required',
        ];
    }

    private function diplomatPrimaryRules()
    {
        return [
            'firstName' => 'required',
            'middleName' => 'required',
            'lastName' => 'required',

            'idNumber' => 'required',
            'gender' => 'required',
            'institution' => 'required',
            'dob' => 'required',

            'country' => 'required',
            'frontIDFile' => 'required|max:200|mimes:jpeg,jpg,png',
            'backIDFile' => 'required|max:200|mimes:jpeg,jpg,png',
            'passportFile' => 'required|max:200|mimes:jpeg,jpg,png'
        ];
    }

    private function diplomatSecondaryRules()
    {
        return [
            'firstName' => 'required',
            'middleName' => 'required',
            'lastName' => 'required',

            'idNumber' => 'required',
            'gender' => 'required',
            'institution' => 'required',
            'dob' => 'required',

            'country' => 'required',
            'frontIDFile' => 'required|max:200|mimes:jpeg,jpg,png',
            'backIDFile' => 'required|max:200|mimes:jpeg,jpg,png',
            'passportFile' => 'required|max:200|mimes:jpeg,jpg,png',

            'tcraReason' => 'required'
        ];
    }

    private function NewVisitorRegPrimaryRules()
    {
        return [
            'issuingCountry' => 'required',
            'fingerCode' => 'required',
            'fingerData' => 'required',
        ];
    }

    private function NewVisitorRegSecondaryRules()
    {
        return [
            'tcraReason' => 'required',
            'issuingCountry' => 'required',
            'fingerCode' => 'required',
            'fingerData' => 'required',
        ];
    }

    private function NewBulkRegStartRules()
    {
        return [
            'companyName' => 'required',
        ];
    }

    private function bulkRegCompanySearchRules()
    {
        return [
            'selectedCompanyName' => 'required',
        ];
    }

    private function NewBulkRegSearchRules()
    {
        return [
            'companyName' => 'required',
        ];
    }

    private function NewBulkRegPrimarySpocRules()
    {
        return [
            'spocEmail' => 'required|email',
            'spocMsisdn' => 'required|regex:/^\+?(255)-?([0-9]{3})-?([0-9]{6})$/',
            'NIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required',
            // 'region' => 'required',
            // 'district' => 'required',
            // 'ward' => 'required',
            'village' => 'required',
            //'expiry-date' => 'required',
        ];
    }

    private function NewBulkRegPrimaryCompanyRules()
    {
        return [
            'msisdnFile' => 'required|mimes:csv,txt',
            'companyEmail' => 'required|email',
            'registrationCategory' => 'required',
            'machine2machine' => 'required',
            'companyRegDate' => 'required',
            'tinDate' =>  'required_if:registrationCategory,COMP,CEMP',
            'brelaNumber' => 'required_if:registrationCategory,COMP,CEMP',
            'brelaDate' => 'required_if:registrationCategory,COMP,CEMP',
            'regCertNumber' => 'required_if:registrationCategory,COMP,CEMP',
            'regCertDate' => 'required_if:registrationCategory,COMP,CEMP',

            'TIN' => 'required_if:registrationCategory,COMP,CEMP',
            'TINFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'businessLicenceFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'businessLicence' => 'required_if:registrationCategory,COMP,CEMP',
            'brelaFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'spocAttachmentFile' => 'required_if:registrationCategory,INST|mimes:jpeg,jpg,png|max:200',
        ];
    }

    private function MinorCheckMsisdnRules()
    {
        return [
            'msisdn' => 'required|regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
        ];
    }

    private function MinorRegisterRules() {
        return [
            'parentMsisdn' => 'required |regex:/^(0)-?([0-9]{3})-?([0-9]{6})$/',
            //'minor-relationship' => 'required',
            'parentNIN' => 'required | digits:20',
            'fingerCode' => 'required',
            'fingerData' => 'required',

            'firstName' => 'required',
            'middleName' => 'required',
            'lastName' => 'required',
            'minorDOB' => 'required|before:-18 years',
            //'minorDOB' => 'required|after_or_equal:-18 years',
           // 'minorDOB' => 'required|regex:/\+?([0-31]{2})-?([0-12]{2})-?([1900-2020]{4})$/',

            'minorGender' => 'required',
            //'ID-select' => 'required',
            'idNumber' => 'required',
            //'minorNationality' => 'required',

            'IDFile' => 'required|mimes:jpeg,jpg,png|max:200',
            'potraitFile' => 'required|mimes:jpeg,jpg,png|max:200',
        ];
    }

    private function setPrimaryStartRules()
    {
        return [
            'idType' => 'required',
            //'NIN' => 'required_if:idType,==,N| digits:20',
            'idNumber' => 'required',
        ];
    }

    private function setPrimaryRules()
    {
        return [
            'msisdnPrimary' => 'required',
        ];
    }

    private function setSecondaryRules()
    {
        return [
            'msisdnSecondary' => 'required',
            'tcraReason' => 'required',
        ];
    }

    private function bulkRegSecondaryRules()
    {
        return [
            'msisdnFile' => 'required|mimes:csv,txt',
            'companyEmail' => 'required|email',
            'registrationCategory' => 'required',

            'machine2machine' => 'required',
            'companyRegDate' => 'required',
            'tinDate' =>  'required_if:registrationCategory,COMP,CEMP',
            'brelaNumber' => 'required_if:registrationCategory,COMP,CEMP',
            'brelaDate' => 'required_if:registrationCategory,COMP,CEMP',
            'regCertNumber' => 'required_if:registrationCategory,COMP,CEMP',
            'regCertDate' => 'required_if:registrationCategory,COMP,CEMP',

            'TIN' => 'required_if:registrationCategory,COMP,CEMP',
            'TINFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'businessLicenceFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'businessLicence' => 'required_if:registrationCategory,COMP,CEMP',
            'brelaFile' => 'required_if:registrationCategory,COMP,CEMP|mimes:jpeg,jpg,png|max:200',
            'spocAttachmentFile' => 'required_if:registrationCategory,INST|mimes:jpeg,jpg,png|max:200',
            'tcraReason' => 'required',
        ];
    }

    public function messages()
    {
        return [
            /** START PAGE **/
            'msisdn.required' => 'Please Input Customer\'s phone number !',
            'msisdn.regex' => 'Invalid Customer\'s phone number !',
            'NIN.required' => 'Please Input Customer\'s NIDA ID !',
            'NIN.digits' => 'Invalid Customer\'s NIDA ID Format !',

            /** NEW PRIMARY MSISDN **/
            'fingerCode.required' => 'Please select customer\'s finger index !',
            'fingerData.required' => 'Please capture customer\'s finger print !',

            /** NEW SECONDARY MSISDN **/
            'fingerCode.required' => 'Please select Customer\'s finger index !',
            'fingerData.required' => 'Please capture Customer\'s finger print !',
            'tcraReason.required' => 'Please select TCRA reason !',

            /** START DIPLOMAT PAGE **/
            'msisdn.required' => 'Please input customer\'s phone number !',
            'msisdn.regex' => 'Invalid customer\'s phone number !',
            'passportNumber.required' => 'Please input customer\'s passport number !',

            /** Single Diplomat */
            'firstName.required' => 'Please input first name !',
            'middleName.required' => 'Please input middle name !',
            'lastName.required' => 'Please input last name !',
            'dob.required' => 'Please input Date of birth !',

            'gender.required' => 'Please select gender !',
            'institution.required' => 'Please input Institution name !',

            'country.required' => 'Please select country !',
            'frontIDFile.required' => 'Please upload scanned diplomat ID front side !',
            'backIDFile.required' => 'Please upload scanned diplomat ID back side !',
            'passportFile.required' => 'Please upload scanned Passport !',

            'frontIDFile.mimes' => 'Please upload correct diplomat ID document format, .PNG or .JPEG !',
            'backIDFile.mimes' => 'Please upload correct diplomat ID document format, .PNG or .JPEG !',
            'passportFile.mimes' => 'Please upload correct document format, .PNG or .JPEG !',

			'frontIDFile.max' => 'Maximum upload file of size of 200KB exceeded !',
            'backIDFile.max' => 'Maximum upload file of size of 200KB exceeded !',
            'passportFile.max' => 'Maximum upload file of size of 200KB exceeded !',

            /** NEW VISITOR MSISDN  */
            'issuingCountry.required' => 'Please select issuing country code !',
            'tcraReason.required' => 'Please select TCRA reason !',

            /** NEW BULK MSISDN  */
            'companyName.required' => 'Please input company name !',

            /** NEW BULK SEARCH  */
            'company.required' => 'Please select company !',

            /** BULK REGISTRATION Page1 **/
            'spocEmail.required' => 'Please input SPOC\'s email adress !',
            'spocEmail.email' => 'Invalid SPOC\'s email adress !',
            'spocMsisdn.required' => 'Please input SPOC\'s phone number !',
            'spocMsisdn.email' => 'Invalid SPOC\'s phone number !',
            'NIN.required' => 'Please input NIDA ID !',
            'NIN.digits' => 'Invalid NIDA ID Format !',
            // 'fingerCode.required' => 'Please select SPOC\'s finger index !',
            // 'fingerData.required' => 'Please capture SPOC\'s finger print !',
            'phoneNumber.required' => 'Please input SPOC\'s phone number!',
            'phoneNumber.digits' => 'Invalid SPOC\'s phone number !',
            'phoneNumber.regex' => 'Invalid SPOC\'s phone number !',
            // 'region.required' => 'Please Select region !',
            // 'district.required' => 'Please Select district !',
            // 'ward.required' => 'Please Select ward !',
            'village.required' => 'Please select street !',
            'expiry-date.required' => 'Please input Expiry Date !',

            /** BULK REGISTRATION Page2 **/
            'spocAttachmentFile.required_if' => 'Please upload SPOC attachment file !',
            'msisdnFile.mimes' => 'Company\'s phone numbers file must be in CSV or TXT format !',
            'msisdnFile.required' => 'Please upload company\'s phone numbers file !',
            'spocAttachmentFile.mimes' => 'SPOC attachment must be in PNG, JPG or JPEG format !',
            'spocAttachmentFile.max' => 'Introduction letter attachment max file Size of 200KB exceeded !',
            'companyEmail.required' => 'Please input company\'s e-mail adress !',
            'companyEmail.email' => 'Invalid company\'s e-mail adress format !',

            'TIN.required_if' => 'Please input company TIN number !',
            'TIN.numeric' => 'Invalid company TIN number !',
            'TINFile.required_if' => 'Please upload TIN file !',
            'TINFile.mimes' => 'TIN file must be in PNG, JPG or JPEG format !',
            'TINFile.max' => 'TIN file max size of 200KB exceeded !',
            'businessLicence.required_if' => 'Please input business licence number !',
            'businessLicence.numeric' => 'Invalid business licence number !',
            'businessLicenceFile.required_if' => 'Please upload business licence file !',
            'businessLicenceFile.mimes' => 'Business licence file must be in PNG, JPG or JPEG format !',
            'businessLicenceFile.max' => 'Business licence file max Size of 200KB  exceeded !',
            'brelaFile.required_if' => 'Please upload Certificate of Incorporation (BRELA) file !',
            'brelaFile.mimes' => 'BRELA file must be in PNG, JPG or JPEG format !',
            'brelaFile.max' => 'Certificate of Incorporation (BRELA) file Max  Size of 200KB exceeded !',
            'registrationCategory.required' => 'Please select registration category !',
            'machine2machine.required' => 'Please select if  Machine-to-machine registration !',
            'companyRegDate.required' => 'Please select company registration date !',
            'tinDate.required_if' =>  'Please select TIN registration date !',
            'brelaNumber.required_if' => 'Please input Incorporation(BRELA) number !',
            'brelaDate.required_if' => 'Please select Incorporation(BRELA) registration date !',
            'regCertNumber.required_if' => 'Please input Certificate of Registration  number !',
            'regCertDate.required_if' => 'Please select Certificate of Registration date !',

            /** MINOR REGISTRATION */
            'parentMsisdn.required' => 'Please input parent\'s phone number!',
            'parentMsisdn.regex' => 'Invalid parent\'s phone number !',
            'parentNIN.required' => 'Please input parent\'s NIN !',
            'parentNIN.digits' => 'Invalid parent\'s NIN !',
            'minor-relationship.required' => 'Please select parent Relationship to Minor !',

            // 'firstName.required' => 'Please input minor\'s first name !',
            // 'middleName.required' => 'Please input minor\'s middle name !',
            // 'lastName.required' => 'Please input minor\'s last name !',
            'minorDOB.required' => 'Please select minor\'s Date of Birth !',
            'minorDOB.before_or_equal' => 'Minor\'s age should not exceed 18 years !',
            'minorGender.required' => 'Please input minor\'s gender !',
            'ID-select.required' => 'Please select Minor\'s ID Type !',
            'idNumber.required' => 'Please input minor\'s ID number !',
            'minorNationality.required' => 'Please select minor\'s nationality !',
            'IDFile.required' => 'Please upload minor\'s ID Photo !',
            'IDFile.mimes' => 'Please upload minor\'s ID Photo format in JPG or JPEG !',
            'potraitFile.required' => 'Please upload minor\'s potrait photo !',
            'potraitFile.mimes' => 'Please upload minor\'s potrait photo format in JPG or JPEG !',
            'IDFile.max' => 'Minor\'s ID Certificate/Passport max size of 200KB exceeded !',
            'potraitFile.max' => 'Minor\'s potrait photo max size of 200KB exceeded !',

            /** START SET PRIMARY */
            'NIN.required_if' => 'Please input customer NIN !',
            'idNumber.required_if' => 'Please input customer NIN !',
            'idNumber.required' => 'Please input customer ID number !',
            'NIN.digits' => 'Invalid customer\'s NIN ! !',
            'idType.required' => 'Please select customer\'s ID category !',

            /** SET PRIMARY */
            'msisdnPrimary.required' => 'Please select one msisdn to set as primary !',

            /** SET SECONDARY */
            'tcraReason.required' => 'Please select reason for seeking approval of secondary SIM number !',
            'msisdnSecondary.required' => 'Please select customer MSISDN to set as secondary SIM number !',

            /** BULK COMPANY SEARCH RULES */

            'Company.required' => 'Please select company !',
            'CompanyName.required' => 'Please select company !',
            'bulkTcraReason.required' => 'Please select reason for seeking approval of bulk secondary SIM numbers !',
            'selectedCompanyName.required' => 'Please select company !',

            /** De-Reg  */
             'deregMsisdn.required' => 'Please select customer Msisdn to De-register !',
             'codeNumber.required' => 'Please input De-registration code !',
             'codeNumber.digits' => 'Invalid De-registration code !',
             'deregReason.required' => 'Please select De-registration reason !'
        ];
    }
}
