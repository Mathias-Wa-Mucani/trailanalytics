<?php

namespace App\Http\Controllers\Api;

use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pwd\PwdDetailsRequest;
use App\Http\Requests\Pwd\PwdRegistrationRequest;
use App\Http\Resources\Pwd\CareTakerResource;
use App\Http\Resources\Pwd\PwdContactResource;
use App\Http\Resources\Pwd\PwdDisabilityIdentificationResource;
use App\Http\Resources\Pwd\PwdEducationResource;
use App\Http\Resources\Pwd\PwdIdentificationResource;
use App\Http\Resources\Pwd\PwdLocationResource;
use App\Http\Resources\Pwd\PwdOtherInfoResource;
use App\Http\Resources\Pwd\PwdRegistrationServicesReceivedResource;
use App\Http\Resources\Pwd\PwdRegistrationSupportRequiredResource;
use App\Http\Resources\PwdDetailsResource;
use App\Http\Resources\PwdListResource;
use App\Models\PwdRegistration;
use App\Repositories\PwdRegistrationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PwdApiController extends ApiController
{
    protected $pwdRegistrationRepository;

    public function __construct(
        PwdRegistrationRepositoryInterface $pwdRegistrationRepository
    ) {
        $this->pwdRegistrationRepository = $pwdRegistrationRepository;
    }


    public function pwd_details(PwdDetailsRequest $request)
    {
        $request = $request->validated();
        if ($pwd = $this->pwdRegistrationRepository->getByPwdNumber(@$request['pwd_number'])) {
            if (!$pwd) {
                return $this->errorResponse($pwd);
            }

            if ($pwd->is_caretaker) {
                return $this->showData(new CareTakerResource($pwd));
            }

            switch (@$request['section']) {
                case 'pwd_identification':
                    return $this->showData(new PwdIdentificationResource($pwd));
                    break;

                case 'pwd_contact':
                    return $this->showData(new PwdContactResource($pwd));
                    break;

                case 'pwd_location':
                    return $this->showData(new PwdLocationResource($pwd));
                    break;

                case 'pwd_education':
                    return $this->showData(new PwdEducationResource($pwd));
                    break;

                case 'pwd_disability_identification':
                    return $this->showData(new PwdDisabilityIdentificationResource($pwd));
                    break;

                case 'pwd_other_info':
                    return $this->showData(new PwdOtherInfoResource($pwd));
                    break;

                case 'pwd_services_received':
                    return $this->showData(new PwdRegistrationServicesReceivedResource($pwd));
                    break;

                case 'pwd_support_required':
                    return $this->showData(new PwdRegistrationSupportRequiredResource($pwd));
                    break;

                default:
                    // return $pwd;
                    return $this->showData(new PwdDetailsResource($pwd));
            }
        }

        return $this->errorResponse("PWD_NOT_FOUND");
    }

    public function add_new_pwd(PwdRegistrationRequest $request)
    {
        // return $request;
        $extra = $request;
        $request = $request->validated();
        if ($result = $this->pwdRegistrationRepository->SavePwd(@$request, $extra)) {
            if ($result instanceof Model) {
                if ($result->IsCaretaker()) {
                    return $this->showData(new CareTakerResource($result));
                }
                return $this->showData(new PwdDetailsResource($result));
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }


    public function get_pwds()
    {
        return $this->showData(PwdListResource::collection($this->pwdRegistrationRepository->getPwds()), ModelHelper::LastUpdated($this->pwdRegistrationRepository->getPwds()));
    }
}
