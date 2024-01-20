<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pwd\PwdGroupApplicationDetailsRequest;
use App\Http\Requests\Pwd\PwdGroupApplicationRequest;
use App\Http\Resources\PwdGroupApplicationResource;
use App\Repositories\PwdGroupApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PwdGroupApplicationApiController extends ApiController
{
    protected $pwdApplicationRepository;

    public function __construct(
        PwdGroupApplicationRepositoryInterface $pwdApplicationRepository
    ) {
        $this->pwdApplicationRepository = $pwdApplicationRepository;
    }

    public function index()
    {
        return $this->showData(PwdGroupApplicationResource::collection($this->pwdApplicationRepository->getApplications()), ModelHelper::LastUpdated($this->pwdApplicationRepository->getApplications()));
    }

    public function add_new_application(PwdGroupApplicationRequest $request)
    {
        $extra = $request;
        $request = $request->validated();
        // $request = $request->only(
        //     [
        //         //basic information
        //         'device_app_number', 'app_number', 'pwd_grp_a_registration_id', 'stp_project_industry_id', 'project_description', 'implementation_period', 'total_cost', 'stp_quarter_id', 'stp_financial_year_id',

        //         // documents
        //         'land_availability_proof', 'meeting_minutes', 'bank_statement',

        //         // budget and sales projection
        //         'budget', 'sales_projection',

        //         // budget summary
        //         'borrowed', 'financial_contribution', 'non_financial_contribution',

        //         // bank details
        //         'account_number', 'account_name', 'stp_bank_id', 'account_branch',

        //         'preparedness'
        //     ]
        // );

        $request['budget'] = @$request['budget'] ?? [];
        $request['sales_projection'] = $request['sales_projection'] ?? [];

        // return $request;

        if ($result = $this->pwdApplicationRepository->SavePwdGroupApplication(@$request, $extra)) {
            if ($result instanceof Model) {
                return $this->showData(new PwdGroupApplicationResource($result));
                // return $this->showData($result);
            }
            // return $result;
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }


    /**
     * Get group application details
     */
    public function get_application_details(PwdGroupApplicationDetailsRequest $request)
    {
        $request = $request->only(['app_number']);
        $record = $this->pwdApplicationRepository->getByApplicationNumber($request['app_number']);
        return $this->showData(new PwdGroupApplicationResource($record));
    }
}
