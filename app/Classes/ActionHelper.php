<?php

namespace App\Classes;

use App\Models\AppraisalDistrict;
use App\Models\AppraisalNationalDeskReview;
use App\Models\AppraisalNationalDeskReviewDetail;
use App\Models\AppraisalNationalFieldReview;
use App\Models\AppraisalNationalFunding;
use App\Models\BudgetItem;
use App\Models\DisabilityGuiding;
use App\Models\DisabilityTypeCause;
use App\Models\DisbursementNational;
use App\Models\PwdDisabilityTypeCause;
use App\Models\PwdGroupApplicationSale;
use App\Models\PwdGroupMember;
use App\Models\PwdRegistrationGuiding;
use App\Models\PwdRegistrationService;
use App\Models\PwdRegistrationSupport;
use App\Models\PwdService;
use App\Models\SubCounty;
use App\Models\SystemSetting;

class ActionHelper
{
    public static function UpdateIds()
    {
        return array(
            class_basename(SystemSetting::class) => 'id',
            class_basename(DisabilityGuiding::class) => 'id',
            class_basename(PwdRegistrationGuiding::class) => 'id',
            class_basename(PwdRegistrationService::class) => 'id',
            class_basename(PwdRegistrationSupport::class) => 'id',
            class_basename(PwdGroupMember::class) => 'id',
            class_basename(BudgetItem::class) => 'id',
            class_basename(PwdGroupApplicationSale::class) => 'id',
            class_basename(AppraisalNationalDeskReviewDetail::class) => 'id',
            class_basename(DisabilityTypeCause::class) => 'id',
            class_basename(PwdDisabilityTypeCause::class) => 'id',
            class_basename(AppraisalNationalDeskReview::class) => 'application_id',
            class_basename(AppraisalNationalFieldReview::class) => 'application_id',
            class_basename(AppraisalNationalFunding::class) => 'application_id',
            class_basename(DisbursementNational::class) => 'id',
            class_basename(PwdService::class) => 'id',
            class_basename(AppraisalDistrict::class) => 'application_id',
        );
    }

    public static function ImportantFields()
    {
        return  array(
            class_basename(SystemSetting::class) => 'variable_name',
            class_basename(DisabilityGuiding::class) => 'description',
            class_basename(PwdRegistrationGuiding::class) => 'disability_guiding_id',
            class_basename(PwdRegistrationService::class) => 'pwd_service_received_id',
            class_basename(PwdRegistrationSupport::class) => 'pwd_support_required_id',
            class_basename(PwdGroupMember::class) => 'pwd_registration_id',
            class_basename(BudgetItem::class) => 'item_name',
            class_basename(PwdGroupApplicationSale::class) => 'product_name',
            class_basename(AppraisalNationalDeskReviewDetail::class) => 'is_pass',
            class_basename(DisabilityTypeCause::class) => 'disability_cause_id',
            class_basename(PwdDisabilityTypeCause::class) => 'stp_disability_cause_id',
            class_basename(AppraisalNationalDeskReview::class) => 'application_id',
            class_basename(AppraisalNationalFieldReview::class) => 'application_id',
            class_basename(AppraisalNationalFunding::class) => 'application_id',
            class_basename(DisbursementNational::class) => 'application_id',
            class_basename(PwdService::class) => 'name',
            class_basename(AppraisalDistrict::class) => 'application_id',
        );
    }

    public static function ForeignKeys()
    {
        return  array(
            class_basename(SystemSetting::class) => '',
            class_basename(DisabilityGuiding::class) => 'disability_id',
            class_basename(DisabilityGuiding::class) => 'disability_id',
            class_basename(PwdRegistrationGuiding::class) => 'pwd_registration_id',
            class_basename(PwdRegistrationService::class) => 'pwd_registration_id',
            class_basename(PwdRegistrationSupport::class) => 'pwd_registration_id',
            class_basename(PwdGroupMember::class) => 'pwd_grp_a_registration_id',
            class_basename(BudgetItem::class) => 'budgetable_id',
            class_basename(PwdGroupApplicationSale::class) => 'pwd_grp_b_applic_main_id',
            class_basename(AppraisalNationalDeskReviewDetail::class) => 'appraisal_national_deskreview_id',
            class_basename(DisabilityTypeCause::class) => 'disability_id',
            class_basename(PwdDisabilityTypeCause::class) => 'pwd_registration_id',
            class_basename(AppraisalNationalDeskReview::class) => 'application_id',
            class_basename(AppraisalNationalFieldReview::class) => 'application_id',
            class_basename(AppraisalNationalFunding::class) => 'application_id',
            class_basename(DisbursementNational::class) => 'application_id',
            class_basename(PwdService::class) => 'pwd_services_categories_id',
            class_basename(AppraisalDistrict::class) => 'application_id',
        );
    }

    public static function PolymorshipModels()
    {
        return  array(
            class_basename(BudgetItem::class) => 'budgetable_id',
            class_basename(BudgetItem::class) => 'budgetable_id',
        );
    }

    public static function ArrayTablesAllowDuplicates()
    {
        return ['BudgetItem', 'PwdGroupApplicationSale'];
    }

    public static function ArrayTimeStampFields()
    {
        return  array(
            'start_date',
            'end_date',
            'date_established',
            'dob',
            'issue_date',
            // 'response_date'
        );
    }

    public static function ArrayPhoneNumberFields()
    {
        return  array(
            'pri_telephone',
            'sec_telephone',
        );
    }


    public static function ArrayAutoDates()
    {
        return  [
            'assign_at',
            'deskdecision_at',
            'approved_at',
            'approve_at',
            'fieldreview_assign_at',
            'fielddecision_at',
            'fundingddecision_at',
            'disbursement_at',
            'is_recieved_at',
            'review_date',
            // 'issue_date',
            'response_date',
            'escalated_at',
            'is_selected_at',
        ];
    }


    public static function ArrayPasswords()
    {
        return  array(
            'password'
        );
    }

    public static function ArrayImageFolders()
    {
        return  array(
            'attachment_' => 'CapacityBuilding',
            'legal_doc_' => 'Legal',
            'plan___' => 'plans',
            'file_on_disk_name' => 'temp'
        );
    }

    public static function ArrayNumericFields()
    {
        return  array(
            'total_cost',
            'quantity',
            'unit_price',
            'expected_sale',
            'amount',
            'financial_contribution',
            'borrowed',
            'unit_price',
            'amount_requested',
            'amount_approved',
            'approved_amount',
            'amount_received',
            'member_verification',
            'males',
            'females',
            'approved_amount',
            'amount_received',
            'house_hold_size',
        );
    }

    public static function CheckBoxBooleanFields()
    {
        return  [
            class_basename(SubCounty::class) => [
                'country_id'
            ],
        ];
    }

    public static function ModelUniqueFields()
    {
        return  array(
            // class_basename(WeatherStationRainFall::class) => ['reporting_date', 'rec_loc_station_id'],
            // class_basename(WeatherStationTemperature::class) => ['reporting_date', 'rec_loc_station_id'],
            // class_basename(WeatherStationEvaporation::class) => ['reporting_date', 'rec_loc_station_id'],
        );
    }
}
