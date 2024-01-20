<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppraisalNationalFieldVerificationRequest;
use App\Http\Resources\AppraisalNationalDeskReviewResource;
use App\Http\Resources\AppraisalNationalFieldViewsResource;
use App\Models\AppraisalNationalDeskReview;
use App\Models\AppraisalNationalFieldReview;
use App\Models\PwdGroupApplication;
use App\Repositories\AppraisalFieldReviewDetailRepositoryInterface;
use App\Repositories\AppraisalFieldReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AppraisalApiController extends ApiController
{

    protected $fieldReviewRepository, $fieldReviewDetailRepository;

    public function __construct(
        AppraisalFieldReviewRepositoryInterface $fieldReviewRepository,
        AppraisalFieldReviewDetailRepositoryInterface $fieldReviewDetailRepository
    ) {
        $this->fieldReviewRepository = $fieldReviewRepository;
        $this->fieldReviewDetailRepository = $fieldReviewDetailRepository;
    }

    public function field_verification_applications()
    {
        if (auth()->user()->is_admin) {
            $results = ModelHelper::PendingFieldReviewAssignments();
        } else {
            $results = ModelHelper::PendingFieldReviewAssignments(false, auth()->user());
        }
        $results = $results->whereNotNull('fieldreview_id')->get();
        
        return $this->showData(AppraisalNationalFieldViewsResource::collection($results), ModelHelper::LastUpdated($results));
    }

    public function verify_field_verification_application(AppraisalNationalFieldVerificationRequest $request)
    {
        $request = $request->validated();
        // $request = $request->only([
        //     'appraisal_national_b_fieldreview_id', 'village_id', 'address',

        //     'grp_name', 'males', 'females', 'stp_project_industry_id', 'amount_requested', 'project_description',
        //     'member_verification', 'member_verifying_id', 'absence_reason',

        //     'certificate_approved', 'certificate_number', 'age_group', 'enterprise_by_home', 'year_registered',

        //     'member_verifying_id', 'other_info',
        //     'fielddecision_id', 'fielddecision_comments', 'fielddecision_financial_year_id', 'fielddecision_quarter_id'
        // ]);

        // return $request;

        if ($result = $this->fieldReviewDetailRepository->addFieldReview(@$request)) {
            if ($result instanceof Model) {
                return $this->successMessage();
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }
}
