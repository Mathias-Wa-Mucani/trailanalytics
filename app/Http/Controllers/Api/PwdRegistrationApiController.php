<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\PwdContactRequest;
use App\Http\Requests\Registration\PwdDisabilityDescriptionRequest;
use App\Http\Requests\Registration\PwdDisabilityIdentificationRequest;
use App\Http\Requests\Registration\PwdDisabilityPhotographsRequest;
use App\Http\Requests\Registration\PwdEducationRequest;
use App\Http\Requests\Registration\PwdIdentificationRequest;
use App\Http\Requests\Registration\PwdLocationRequest;
use App\Http\Requests\Registration\PwdOtherInfoRequest;
use App\Http\Requests\Registration\PwdServicesReceivedRequest;
use App\Http\Requests\Registration\PwdSupportRequiredRequest;
use App\Http\Resources\Pwd\CareTakerResource;
use App\Repositories\PwdRegistrationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PwdRegistrationApiController extends ApiController
{
    protected $PwdRegistrationRepository;
    protected $user;

    public function __construct(
        PwdRegistrationRepositoryInterface $PwdRegistrationRepository
    ) {
        $this->PwdRegistrationRepository = $PwdRegistrationRepository;
    }

    private function updatePwd($data)
    {
        if ($result = $this->PwdRegistrationRepository->updatePwd($data)) {
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }
    }

    /**
     * Handles Pwd identification details. 
     * This is the initial step in pwd registration process
     */
    public function pwd_identification(PwdIdentificationRequest $request)
    {
        $request = $request->only(['financial_year_id', 'nin', 'is_caretaker', 'surname', 'given_name', 'other_name', 'dob', 'sex', 'pwd_number']);
        // return $request;
        if ($result = $this->PwdRegistrationRepository->SavePwdIdentification($request)) {
            if ($result instanceof Model) {
                if (@$result->is_caretaker) {
                    return $this->showData(new CareTakerResource($result));
                }
                $payload = array('id' => $result->id, 'pwd_number' => $result->pwd_number);
                return $this->showData($payload);
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * Handles Pwd contact details. 
     */
    public function pwd_contact(PwdContactRequest $request)
    {
        $request = $request->only(['pri_telephone', 'sec_telephone', 'email', 'box_number', 'pwd_number']);
        if ($result = $this->PwdRegistrationRepository->SavePwdContact($request)) {
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * Handles Pwd contact details. 
     */
    public function pwd_location(PwdLocationRequest $request)
    {
        $request = $request->only(['dcode', 'ccode', 'scode', 'parish', 'village', 'address', 'pwd_number']);
        return $this->updatePwd($request);
    }

    /**
     * Handles Pwd Education details. 
     */
    public function pwd_education(PwdEducationRequest $request)
    {
        $request = $request->only(['educ_level_id', 'educ_certificate_id', 'educ_comment', 'pwd_number']);
        return $this->updatePwd($request);
    }

    /**
     * Handles Pwd Disability Identification. 
     */
    public function pwd_disability_identification(PwdDisabilityIdentificationRequest $request)
    {
        $request = $request->only(['disability_type_id', 'pwd_number']);
        return $this->updatePwd($request);
    }

    /**
     * Handles Pwd Disability Identification. 
     */
    public function pwd_disability_description(PwdDisabilityDescriptionRequest $request)
    {
        $request = $request->only(['disability_guide', 'disability_severity_id', 'other_disability', 'pwd_number']);
        if ($result = $this->PwdRegistrationRepository->SavePwdDisabilityDescription($request)) {
            // return $result;
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * Handles Pwd Disability Photographs. 
     */
    public function pwd_disability_photographs(PwdDisabilityPhotographsRequest $request)
    {
        if ($result = $this->PwdRegistrationRepository->UploadDisabilityPhotographs($request)) {
            // return $result;
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }
        return $this->errorResponse();
    }

    /**
     * Handles Pwd Other info. 
     */
    public function pwd_other_info(PwdOtherInfoRequest $request)
    {
        $request = $request->only(['house_hold_size', 'slums', 'hiv', 'single_parent', 'pwd_number']);
        return $this->updatePwd($request);
    }

    /**
     * Handles Pwd Services requested. 
     */
    public function pwd_services_received(PwdServicesReceivedRequest $request)
    {
        $request = $request->only(['services_received', 'pwd_number']);
        if ($result = $this->PwdRegistrationRepository->SavePwdServicesReceived($request)) {
            // return $result;
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * Handles Pwd Supprot required. 
     */
    public function pwd_support_required(PwdSupportRequiredRequest $request)
    {
        $request = $request->only(['support_required', 'pwd_number']);
        if ($result = $this->PwdRegistrationRepository->SavePwdSupportRequired($request)) {
            // return $result;
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }
}
