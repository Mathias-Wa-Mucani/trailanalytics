<?php


namespace App\Classes;

use App\Models\PwdGroupRegistration;
use Illuminate\Database\Eloquent\Model;


class DatatablesGroupApplication extends Model
{

    public function group()
    {
        return $this->belongsTo(PwdGroupRegistration::class, 'pwd_grp_a_registration_id');
    }

    public static function laratablesAdditionalColumns()
    {
        // dd(self::class);
        return ['pwd_grp_a_registration_id', 'application_id', 'district', 'district_id', 'total_cost', 'financial_contribution', 'borrowed', 'ds_appraisal_decision_id', 'app_number', 'grp_number', 'group_name', 'district'];
    }

    public static function laratablesCustomAmountRequested($record)
    {
        return GeneralHelper::to_money_format(@$record->borrowed);
    }

    public static function laratablesCustomMaleFemale($record)
    {
        // return '';
        return @$record->MaleFemaleRatio();
    }

    public static function laratablesCustomNationalSubmissions($record)
    {
        return @$record->NationalSubmissionsText();
    }

    public function NationalSubmissionsText()
    {
        return 0;
        return @$this->num_ds_appraisal ? 'Resubmission (' . @$this->num_ds_appraisal . ')' : '-';
    }

    public static function db_appraisals_columns()
    {
        return 'appraisals.dt_columns';
    }

    public static function db_disbursement_columns()
    {
        return 'disbursements.dt_columns';
    }

    public function MaleFemaleRatio()
    {
        return @$this->group->MaleMembersTotal() . '/' . @$this->group->FemaleMembersTotal();
    }

    public static function laratablesSearchGroupName($query, $searchValue)
    {
        return $query->orwhereRaw('(group_name) ILIKE ?', ['%' . strtoupper($searchValue) . '%'])
            ->orwhereRaw('(app_number) ILIKE ?', ['%' . strtoupper($searchValue) . '%'])
            ->orwhereRaw('(grp_number) ILIKE ?', ['%' . strtoupper($searchValue) . '%'])
            ->orwhereRaw('(district) ILIKE ?', ['%' . strtoupper($searchValue) . '%'])
            ->orwhereRaw('(project_industry) ILIKE ?', ['%' . strtoupper($searchValue) . '%']);
    }

    public static function laratablesCustomEstimatedBudget($record)
    {
        return GeneralHelper::to_money_format(@$record->total_cost);
    }

    public static function laratablesCustomViewAmountRequested($record)
    {
        return GeneralHelper::to_money_format(@$record->requested_amount ?? @$record->total_cost);
        // return GeneralHelper::to_money_format(@$record->total_cost);
    }

    public static function laratablesCustomApprovedBank($record)
    {
        return GeneralHelper::SmartRecord(@$record->approved_account_bank);
    }

    public static function laratablesCustomContribution($record)
    {
        return GeneralHelper::to_money_format(@$record->financial_contribution);
    }

    public static function laratablesCustomNationalDeskAssessmentAction($record)
    {
        return view(self::db_appraisals_columns() . '.national_desk_assessment_action', compact('record'))->render();
    }

    public static function laratablesCustomFundingReviewAssignmentAction($record)
    {
        return view(self::db_appraisals_columns() . '.funding_review_assignment_action', compact('record'))->render();
    }

    public static function laratablesCustomDeskApprovalAction($record)
    {
        return view(self::db_appraisals_columns() . '.national_desk_assessment_action', compact('record'))->render();
    }

    public static function laratablesCustomDisbursementQualifyingApplicationAction($record)
    {
        return view(self::db_disbursement_columns() . '.qualifying_application_action', compact('record'))->render();
    }
}
