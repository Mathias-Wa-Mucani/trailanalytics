<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Classes\RolePermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pwd\PwdGroupDetailsRequest;
use App\Http\Requests\Pwd\PwdGroupRegistrationRequest;
use App\Http\Resources\PwdGroupListResource;
use App\Http\Resources\PwdGroupResource;
use App\Models\PwdGroupRegistration;
use App\Repositories\PwdGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PwdGroupApiController extends ApiController
{
    protected $pwdGroupRepository;

    public function __construct(
        PwdGroupRepositoryInterface $pwdGroupRepository
    ) {
        $this->pwdGroupRepository = $pwdGroupRepository;
    }

    public function index()
    {
        $groups = $this->pwdGroupRepository->getGroups();
        return $this->showData(PwdGroupListResource::collection($groups), ModelHelper::LastUpdated($groups));
    }

    /**
     * Adds new pwd group
     */
    public function add_new_group(PwdGroupRegistrationRequest $request)
    {
        // return $request->all();
        // return $request;
        $extra = $request;
        $request = $request->validated();
        $request['members'] = $request['members'] ?? [];
        // return $request;

        if ($result = $this->pwdGroupRepository->SavePwdGroup(@$request, $extra)) {
            if ($result instanceof Model) {
                return $this->showData(new PwdGroupResource($result));
            }
            return $this->errorResponse($result);
        }

        return $this->errorResponse();
    }


    /**
     * Get group details
     */
    public function get_group_details(PwdGroupDetailsRequest $request)
    {
        $request = $request->validated();
        if ($record = $this->pwdGroupRepository->getByGroupNumber($request['grp_number'])) {
            return $this->showData(new PwdGroupResource($record));
        }
        return $this->notFoundRespose("PWD_GROUP_NOT_FOUND");
    }
}
