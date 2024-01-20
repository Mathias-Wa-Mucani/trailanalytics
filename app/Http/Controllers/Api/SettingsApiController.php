<?php

namespace App\Http\Controllers\Api;

use App\Classes\ModelHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ModelController;
use App\Http\Resources\BankResource;
use App\Http\Resources\CommitteeRoleResource;
use App\Http\Resources\EducationalCertificateResource;
use App\Http\Resources\EducationalLevelResource;
use App\Http\Resources\FinancialYearQuarterResource;
use App\Http\Resources\FinancialYearResource;
use App\Http\Resources\PositionResource;
use App\Http\Resources\ProjectIndustryResource;
use App\Http\Resources\PwdServiceReceivedResource;
use App\Http\Resources\PwdServicesCategoryResource;
use App\Http\Resources\PwdSupportRequiredResource;
use App\Http\Resources\RolePermissionResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UnitMeasureResource;
use App\Models\Bank;
use App\Models\CommitteeRole;
use App\Models\EducationalCertificate;
use App\Models\EducationalLevel;
use App\Models\FinancialYear;
use App\Models\FinancialYearQuarter;
use App\Models\Position;
use App\Models\ProjectIndustry;
use App\Models\PwdService;
use App\Models\PwdServiceCategory;
use App\Models\PwdServiceReceived;
use App\Models\PwdSupportRequired;
use App\Models\Role;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;

class SettingsApiController extends ApiController
{
    /**
     * Returns financial years
     */
    public function get_financial_years()
    {
        return $this->showData(FinancialYearResource::collection(FinancialYear::all()), ModelHelper::LastUpdated(FinancialYear::class));
    }

     /**
     * Returns financial year quarters
     */
    public function get_financial_year_quarters()
    {
        return $this->showData(FinancialYearQuarterResource::collection(FinancialYearQuarter::all()), ModelHelper::LastUpdated(FinancialYearQuarter::class));
    }

    /**
     * Returns pwd available services to render
     */
    public function get_pwd_services_categories()
    {
        // return $this->showData()
        return $this->showData(PwdServicesCategoryResource::collection(PwdServiceCategory::all()), ModelHelper::LastUpdated(PwdServiceCategory::class));
    }

    /**
     * Returns pwd available services to render
     */
    public function get_services_received()
    {
        return $this->showData(PwdServiceReceivedResource::collection(PwdServiceReceived::all()), ModelHelper::LastUpdated(PwdServiceReceived::class));
    }

    /**
     * Returns pwd support required
     */
    public function get_support_required()
    {
        return $this->showData(PwdSupportRequiredResource::collection(PwdSupportRequired::all()), ModelHelper::LastUpdated(PwdSupportRequired::class));
    }

    /**
     * Returns all banks
     */
    public function get_banks()
    {
        return $this->showData(BankResource::collection(Bank::all()), ModelHelper::LastUpdated(Bank::class));
    }

    /**
     * Returns all banks
     */
    public function get_positions()
    {
        return $this->showData(PositionResource::collection(Position::all()), ModelHelper::LastUpdated(Position::class));
    }

    /**
     * Returns all project industries
     */
    public function get_project_industries()
    {
        return $this->showData(ProjectIndustryResource::collection(ProjectIndustry::all()), ModelHelper::LastUpdated(ProjectIndustry::class));
    }

    /**
     * Returns all unit measures
     */
    public function get_unit_measures()
    {
        return $this->showData(UnitMeasureResource::collection(UnitMeasure::all()), ModelHelper::LastUpdated(UnitMeasure::class));
    }

    /**
     * Returns all unit measures
     */
    public function get_committee_roles()
    {
        return $this->showData(CommitteeRoleResource::collection(CommitteeRole::all()), ModelHelper::LastUpdated(CommitteeRole::class));
    }

    /**
     * Returns all educational levels
     */
    public function get_educational_levels()
    {
        return $this->showData(EducationalLevelResource::collection(EducationalLevel::all()), ModelHelper::LastUpdated(EducationalLevel::class));
    }

    /**
     * Returns all educational certificates
     */
    public function get_educational_certificates()
    {
        return $this->showData(EducationalCertificateResource::collection(EducationalCertificate::all()), ModelHelper::LastUpdated(EducationalCertificate::class));
    }

    /**
     * Returns all user roles
     */
    public function get_user_roles()
    {
        return $this->showData(RolePermissionResource::collection(Role::all()), ModelHelper::LastUpdated(Role::class));
    }
}
