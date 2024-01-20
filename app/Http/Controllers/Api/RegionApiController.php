<?php

namespace App\Http\Controllers\Api;

use App\Classes\CacheKeys;
use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ModelController;
use App\Http\Requests\CountySubCountiesRequest;
use App\Http\Requests\DistrictCountiesRequest;
use App\Http\Resources\CountyResource;
use App\Http\Resources\ParishResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\SubCountyResource;
use App\Http\Resources\VillageResource;
use App\Models\County;
use App\Models\District;
use App\Models\Parish;
use App\Models\SubCounty;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionApiController extends ApiController
{
    /**
     * Returns all districts
     */
    public function get_districts()
    {
        return $this->showData(RegionResource::collection(District::all()), ModelHelper::LastUpdated(District::class));
    }

    /**
     * returns district counties
     */
    public function get_district_counties(DistrictCountiesRequest $request)
    {
        $record = District::whereCode(@$request['district_code'])->first();
        return $this->showData(CountyResource::collection(@$record->counties), ModelHelper::LastUpdated(@$record->counties));
    }

    /**
     * returns all subcounties in a county
     */
    public function get_county_subcounties(CountySubCountiesRequest $request)
    {
        $record = County::whereCode(@$request['county_code'])->first();
        return $this->showData(SubCountyResource::collection(@$record->subcounties), ModelHelper::LastUpdated(@$record->subcounties));
    }

    /**
     * returns all counties
     */
    public function get_all_counties(Request $request)
    {
        return $this->showData(CountyResource::collection(County::all()), ModelHelper::LastUpdated(County::class));
    }

    /**
     * returns all subcounties
     */
    public function get_all_subcounties(Request $request)
    {
        return $this->showData(SubCountyResource::collection(SubCounty::all()), ModelHelper::LastUpdated(SubCounty::class));
    }

    /**
     * returns all parishes
     */
    public function get_all_parishes(Request $request)
    {
        $records = Parish::remember(CacheKeys::REMEMBER_TIME)->cacheTags(CacheKeys::CARETAKERS)->get();

        return $this->showData(ParishResource::collection($records), ModelHelper::LastUpdated(Parish::class));
    }

    /**
     * returns all parishes
     */
    public function get_all_villages(Request $request)
    {
        // return 0;
        // return Village::all();
        // $villages = 
        // if (GeneralHelper::app_is_dev()) {
        // } else {
        //     $villages = Village::remember(CacheKeys::REMEMBER_TIME)->cacheTags(CacheKeys::CARETAKERS)->get();
        // }


        $limit = @$request->limit ? @$request->limit : 10000;
        $page = @$request->page && @$request->page > 0 ? @$request->page : 1;
        $skip = ($page - 1) * $limit;

        // $villages = Village::slice($skip, $limit);
        // $villages = Village::paginate($limit);
        // $villages = Village::paginate();

        $villages = Village::paginate($limit);
        // return new VillageResource($villages);

        // return $villages;
        // return $payload = VillageResource::collection($villages);

        $payload =  VillageResource::collection($villages)->response()->getData(true);
        // return response()->json(['success' => true, 'payload' => $payload]);
        // $villages = Village::limit(38000)->remember(CacheKeys::REMEMBER_TIME)->cacheTags(CacheKeys::CARETAKERS)->get();
        return $this->showData($payload['data'], $payload['links']);
    }
}
