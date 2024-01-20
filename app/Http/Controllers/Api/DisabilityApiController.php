<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisabilityGuidingRequest;
use App\Http\Resources\Disability\DisabilitySeverityResource;
use App\Http\Resources\Disability\DisabilityTypesResource;
use App\Http\Resources\DisabilityCauseResource;
use App\Http\Resources\DisabilityGuidingResource;
use App\Models\Disability;
use App\Models\DisabilityCause;
use App\Models\DisabilityGuiding;
use App\Models\DisabilitySeverity;
use Illuminate\Http\Request;

class DisabilityApiController extends ApiController
{
    /**
     * returns all disabilites
     */
    public function index()
    {
        return $this->showData(DisabilityTypesResource::collection(Disability::all()), ModelHelper::LastUpdated(Disability::class));
    }

    /**
     * returns disability guiding questions 
     */
    public function get_disability_guiding(DisabilityGuidingRequest $request)
    {
        $record = Disability::find(@$request['disability_id']);
        return $this->showData(DisabilityGuidingResource::collection(@$record->guide), ModelHelper::LastUpdated(@$record));
    }

    /**
     * returns disability severities
     */
    public function get_disability_severities()
    {
        return $this->showData(DisabilitySeverityResource::collection(DisabilitySeverity::all()), ModelHelper::LastUpdated(DisabilitySeverity::class));
    }

    /**
     * returns disability causes 
     */
    public function get_disability_causes()
    {
        return $this->showData(DisabilityCauseResource::collection(DisabilityCause::all()), ModelHelper::LastUpdated(DisabilityCause::class));
    }

    /**
     * returns all guiding questions 
     */
    public function get_all_guiding_questions()
    {
        return $this->showData(DisabilityGuidingResource::collection(DisabilityGuiding::all()), ModelHelper::LastUpdated(DisabilityGuiding::class));
    }
}
