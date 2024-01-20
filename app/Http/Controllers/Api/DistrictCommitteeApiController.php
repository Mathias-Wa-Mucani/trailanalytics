<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddDistrictCommitteeMemberRequest;
use App\Http\Resources\DistrictCommitteeResource;
use App\Models\DistrictCommittee;
use App\Repositories\DistrictCommitteeRepositoryInterface;
use Illuminate\Http\Request;

class DistrictCommitteeApiController extends ApiController
{
    protected $dcRepository;

    public function __construct(DistrictCommitteeRepositoryInterface $dcRepository)
    {
        $this->dcRepository = $dcRepository;
    }

    public function index()
    {
        return $this->showData(DistrictCommitteeResource::collection($this->dcRepository->getByDistrict(auth()->user()->district_id)), ModelHelper::LastUpdated(DistrictCommittee::whereDistrictId(auth()->user()->district_id)->get()));
    }

    public function add_new_member(AddDistrictCommitteeMemberRequest $request)
    {
        $request = $request->only(['role_id', 'surname', 'given_name', 'other_name', 'pri_telephone', 'sec_telephone', 'email', 'sex', 'nin']);
        return $this->showData(new DistrictCommitteeResource($this->dcRepository->AddNewMember($request)));
    }
}
