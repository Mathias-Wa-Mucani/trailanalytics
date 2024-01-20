<?php

namespace App\Http\Controllers\Api;

use App\Classes\DashboardHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardApiController extends ApiController
{
    public function index()
    {
        $dashboardHelper = new DashboardHelper();
        $payload = array(
            'general_overview' => $dashboardHelper->GeneralOverview(),
            'sex_aggregation' => $dashboardHelper->SexDisaggregation(),
            'disability_breakdown' => $dashboardHelper->disability_breakdown(),
            'group_disaggregation' => $dashboardHelper->GroupDisaggregation(),
            'education_disaggregation' => $dashboardHelper->EducationDisaggregation(),
            'application_statistics' => $dashboardHelper->ApplicationStatistics(),
            'national_appraisal_approval_statistics' => $dashboardHelper->NationalAppraisalApprovalStatistics(),
            'district_appraisal_statistics' => $dashboardHelper->DistrictAppraisalStatistics(),
            'nsg_disbursements' => $dashboardHelper->NSGDisbursements()
        );
        return $this->showData($payload);
    }
}
