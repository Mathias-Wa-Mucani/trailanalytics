<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CloseComplaintRequest;
use App\Http\Requests\Complaints\AddComplaintRequest;
use App\Http\Requests\Complaints\AddGroupComplaintRequest;
use App\Http\Requests\Complaints\AddPwdComplaintRequest;
use App\Http\Resources\ComplaintCategoryResource;
use App\Http\Resources\ComplaintResource;
use App\Models\ComplaintCategory;
use App\Models\Views\ViewPwdComplaintGrievanceDistrict;
use App\Models\Views\ViewPwdComplaintGrievanceNational;
use App\Repositories\ComplaintCategoryRepositoryInterface;
use App\Repositories\GroupComplaintRepositoryInterface;
use App\Repositories\PwdComplaintRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComplaintApiController extends ApiController
{
    protected $complaintCategoryRepository, $pwdComplaintRepository, $groupComplaintRepository;
    public function __construct(
        ComplaintCategoryRepositoryInterface $complaintCategoryRepository,
        PwdComplaintRepositoryInterface $pwdComplaintRepository,
        GroupComplaintRepositoryInterface $groupComplaintRepository
    ) {
        $this->complaintCategoryRepository = $complaintCategoryRepository;
        $this->pwdComplaintRepository = $pwdComplaintRepository;
        $this->groupComplaintRepository = $groupComplaintRepository;
    }

    // gets all complaints and grievances categories
    public function get_complaint_categories()
    {
        $records = $this->complaintCategoryRepository->all();
        return $this->showData(ComplaintCategoryResource::collection($records), ModelHelper::LastUpdated($records));
    }

    // add new pwd complaint 
    public function add_pwd_complaint(AddPwdComplaintRequest $request)
    {
        return $this->errorResponse("NO_LONGER_AVAILABLE");

        $request = $request->only(['pwd_registration_id', 'complaint_category_id', 'description']);
        if ($result = $this->pwdComplaintRepository->addComplaint(@$request)) {
            if ($result instanceof Model) {
                return $this->showData(new ComplaintResource($result));
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    public function add_complaint(AddComplaintRequest $request)
    {
        $extra = $request;
        $request = $request->validated();
        if ($result = $this->pwdComplaintRepository->addComplaint(@$request, $extra)) {
            if ($result instanceof Model) {
                return $this->showData(new ComplaintResource($result));
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    public function close_complaint(CloseComplaintRequest $request)
    {
        // return $this->errorResponse("NO_LONGER_AVAILABLE");
        $extra = $request;
        $request = $request->validated();
        if ($result = $this->pwdComplaintRepository->closeComplaint(@$request, $extra)) {
            if ($result instanceof Model) {
                return $this->successMessage();
                return $this->showData(new ComplaintResource($result));

            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * get pwd complaints
     */

    public function get_district_complaints()
    {
        // $records = ViewPwdComplaintGrievanceDistrict::AuthUserList()->with->get();
        $records = $this->pwdComplaintRepository->all(1);
        return $this->showData(ComplaintResource::collection($records), ModelHelper::LastUpdated($records));
    }

    public function get_national_complaints()
    {
        // $records = ViewPwdComplaintGrievanceNational::AuthUserList()->get();
        $records = $this->pwdComplaintRepository->all(2);
        return $this->showData(ComplaintResource::collection($records), ModelHelper::LastUpdated($records));
    }

    public function get_pwd_complaints()
    {
        return $this->errorResponse("NO_LONGER_AVAILABLE");

        $records = $this->pwdComplaintRepository->all(1);
        return $this->showData(ComplaintResource::collection($records), ModelHelper::LastUpdated($records));
    }

    /**
     * add group complaint
     */
    public function add_group_complaint(AddGroupComplaintRequest $request)
    {
        // return $request;

        return $this->errorResponse("NO_LONGER_AVAILABLE");
        
        $request = $request->only(['pwd_grp_registration_id', 'complaint_category_id', 'description']);
        if ($result = $this->groupComplaintRepository->addComplaint(@$request)) {
            if ($result instanceof Model) {
                return $this->showData(new ComplaintResource($result));
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }

    /**
     * get pwd complaints
     */
    public function get_group_complaints()
    {
        return $this->errorResponse("NO_LONGER_AVAILABLE");
        $records = $this->pwdComplaintRepository->all(2);
        return $this->showData(ComplaintResource::collection($records), ModelHelper::LastUpdated($records));
    }
}
