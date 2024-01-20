<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\GroupRole;
use Illuminate\Http\Request;

class GroupApiController extends ApiController
{
    /**
     * Returns all group roles
     */
    public function get_group_roles()
    {
        return $this->showData(RoleResource::collection(GroupRole::all()));
    }
}
