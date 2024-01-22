<?php

namespace App\Classes;

use App\Models\AppraisalDistrict;
use App\Models\District;
use App\Models\DistrictCommittee;
use App\Models\FinancialYear;
use App\Models\FinancialYearQuarter;
use App\Models\PwdComplaintGrievance;
use App\Models\PwdGroupApplication;
use App\Models\PwdGroupRegistration;
use App\Models\PwdRegistration;
use App\Models\SystemSetting;
use App\Models\User;
use App\Models\Views\ViewPwdGroupApplication;
use App\Models\AppraisalDistrictReview;
use App\Models\AppraisalNationalDeskReview;
use App\Models\AppraisalNationalFieldReview;
use App\Models\AppraisalNationalFieldReviewDetail;
use App\Models\AppraisalNationalFunding;
use App\Models\OpApplication;
use App\Models\OpGroupRegistration;
use App\Models\OpRegistration;
use App\Models\Views\ViewApplicationDeskApproval;
use App\Models\Views\ViewApplicationDeskAssignment;
use App\Models\Views\ViewApplicationDeskReassignment;
use App\Models\Views\ViewApplicationDeskReview;
use App\Models\Views\ViewApplicationDisbursementNationalApproved;
use App\Models\Views\ViewApplicationDisbursementNationalRecommendation;
use App\Models\Views\ViewApplicationDisbursementNationalSelection;
use App\Models\Views\ViewApplicationDisbursementNsgAssign;
use App\Models\Views\ViewApplicationFieldApproval;
use App\Models\Views\ViewApplicationFieldAssignment;
use App\Models\Views\ViewApplicationFieldReassignment;
use App\Models\Views\ViewApplicationFieldReview;
use App\Models\Views\ViewApplicationFieldReviewApproval;
use App\Models\Views\ViewApplicationFundingApproval;
use App\Models\Views\ViewApplicationFundingAssignment;
use App\Models\Views\ViewApplicationFundingReassignment;
use App\Models\Views\ViewApplicationFundingReview;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class ModelHelper
{


    public static function GetFinancialYears($application_id)
    {
    }

    public static function ResetApplication($application_id)
    {
    }

    public static function deleteApplicationFieldReview($application_id)
    {
    }

    public static function deleteApplicationFundingReview($application_id)
    {
    }

    public static function getApplicationModels()
    {
        $models = [];
        $modelsPath = app_path('Models');
        $modelFiles = File::allFiles($modelsPath);
        // dd($modelFiles);
        // $i = 0;
        foreach ($modelFiles as $modelFile) {
            $_modelFile = $modelFile->getFilenameWithoutExtension();
            if (in_array($_modelFile, self::MorphModels())) {
                $model = 'App\\Models\\' . $_modelFile;
                $models[$_modelFile]['lowercase'] =  GeneralHelper::from_camel_case($_modelFile);
                $models[$_modelFile]['model'] = 'App\\Models\\' . $_modelFile;
                $models[$_modelFile]['db_table'] =  (new $model)->getTable();
            }
        }
        // dd($models);
        return $models;
    }

    public static function MorphModels()
    {
        return [
            // class_basename(PwdRegistration::class),
            class_basename(User::class),
        ];
    }

    public static function getApplicationObservers()
    {
        $models = [];
        $modelsPath = app_path('Models');
        $modelFiles = File::allFiles($modelsPath);
        $observers = [];
        foreach ($modelFiles as $modelFile) {
        }
    }

    public static function TableFromView($view)
    {
        return str_replace('View', '', $view);
    }

    /**
     * gets system settings
     */
    public static function SystemSettings()
    {
        // return SystemSetting::first();
    }

    /**
     * 
     */
    public static function generateModelFromString($string = '')
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }

    /**
     * generates pwd_number
     */
    public static function generateOpNumber($record = null)
    {
        /// "M / KA/ 20 / 00001";

        if (@$record->id) {
            $unique_id = GeneralHelper::add_leading_zeros($record->id);
            $record_number_array = explode('/', $record->pwd_number);
            $record_number_array[count($record_number_array) - 1] = $unique_id;
            return implode("/", $record_number_array);
        }

        $district_abbreviation = auth()->user()->district->abbreviation;
        $sex_abbrev = "D";
        if (@$record->village_id) {
            $district_abbreviation = Village::find(@$record->village_id)->district->abbreviation;
            $sex_abbrev = substr($record->sex, 0, 1);
        } else {
            if (@request()->district_id) {
                $district_abbreviation = District::find(@request()->district_id)->abbreviation;
            }
        }

        $last = OpRegistration::withTrashed()->latest()->first();
        $count = @$last ? (int)$last->id + 1 : 1;
        return $sex_abbrev . "/" . @$district_abbreviation . '/' . self::getCurrentFyYearShort() . '/' . GeneralHelper::add_leading_zeros(@$count);

        // return $sex_abbrev . "/" . @$district_abbreviation . '/' . self::getCurrentFyYearShort() . '/' . GeneralHelper::add_leading_zeros(@$record->id);
    }

    /**
     * generates grp_number
     */
    public static function generateGroupNumber($record = null)
    {
        if (@$record->id) {
            $unique_id = GeneralHelper::add_leading_zeros($record->id);
            $record_number_array = explode('/', $record->grp_number);
            $record_number_array[count($record_number_array) - 1] = $unique_id;
            return implode("/", $record_number_array);
        }

        // $district_abbreviation = auth()->user()->district->abbreviation;
        // if (@$record->village_id) {
        //     $district_abbreviation = Village::find(@$record->village_id)->district->abbreviation;
        // } else {
        //     if (@request()->district_id) {
        //         $district_abbreviation = District::find(@request()->district_id)->abbreviation;
        //     }
        // }

        $last = OpGroupRegistration::withTrashed()->latest()->first();
        $count = @$last ? (int)$last->id + 1 : 1;
        // return "GP/" . $district_abbreviation . '/' . self::getCurrentFyYearShort() . '/' . GeneralHelper::add_leading_zeros(@$count);
        return "GP-" . GeneralHelper::add_leading_zeros(@$count);
    }

    /**
     * generates app_number
     */
    public static function generateGroupApplicationNumber($record = null)
    {
        if (@$record->id) {
            $unique_id = GeneralHelper::add_leading_zeros($record->id);
            $record_number_array = explode('/', $record->app_number);
            $record_number_array[count($record_number_array) - 1] = $unique_id;
            return implode("/", $record_number_array);
        }

        $district_abbreviation = auth()->user()->district->abbreviation;
        if (@$record->pwd_grp_a_registration_id) {
            $village = OpRegistration::find(@$record->pwd_grp_a_registration_id)->village;
            if (@$village) {
                $district_abbreviation = @$village->district->abbreviation;
            }
        }

        $last = OpApplication::withTrashed()->latest()->first();
        $count = @$last ? (int)$last->id + 1 : 1;
        return "APP/" . $district_abbreviation . '/' . self::getCurrentFyYearShort() . '/' . GeneralHelper::add_leading_zeros(@$count);
    }

    /**
     * generates complaints and grievances reference number
     */
    public static function generateComplainReferenceNumber($prefix)
    {
        // $last = PwdComplaintGrievance::latest()->first();
        // dd($pwd_count);
        // $count = @$last ? (int)$last->id + 1 : 1;
        // $count = $count + 1;
        // return @$prefix . date('y') . date('m') . date('d') . GeneralHelper::add_leading_zeros(@$count);
    }

    /**
     * retrieves genders
     */
    public static function getSexs()
    {
        return ["Male", "Female"];
    }

    /**
     * retrieves genders
     */
    public static function MaterializedViews()
    {
        return [
            "rp_pwd",
            "rp_group",
            "rp_applic",
            "rp_dgs",
            "rp_appraisal",
            "rp_nsg"
        ];
    }

    /**
     * plucks year from current financial year
     */
    public static function getCurrentFyYear()
    {
        return FinancialYear::getCurrentFY();
    }

    /**
     * plucks year from current financial year
     */
    public static function getCurrentFyYearShort()
    {
        $currentFY = FinancialYear::getCurrentFY();
        return date("y", strtotime($currentFY->start_date));
    }

    /**
     * plucks year from financial year
     */
    public static function getFYearShort($id)
    {
        $fy = FinancialYear::find($id);
        if ($fy) {
            return date("y", strtotime($fy->start_date));
        }
        return null;
    }

    /**
     * dynamically retrieves current financial year quarter depending at which time we are now
     */
    public static function getCurrentFinancialYearQuarter()
    {
        // $now = Carbon::parse(Carbon::now())->format('d M');
        // $quarter = FinancialYearQuarter::where('start_date', '>=', $now)
        //     ->where('end_date', '<=', $now)
        //     ->first();
        // $now = Carbon::now();
        $quarters = FinancialYearQuarter::all();
        foreach ($quarters as $quarter) {
            $start_date = Carbon::parse($quarter->start_date);
            $end_date = Carbon::parse($quarter->end_date);
            $check = Carbon::now()->between($start_date, $end_date);
            if ($check) {
                break;
            }
        }
        return $check ? $quarter : $check;
        // return FinancialYearQuarter::first();
    }

    /** 
     * Returns latest update time for a model collection
     */
    public static function LastUpdated($model)
    {
        if (!$model instanceof Model) {
            if (!$model instanceof Collection) {
                $model = new $model;
            }
            $last_updated = $model->max('updated_at');
            return ['last_updated' => GeneralHelper::db_date_format_timestamp_24_hours($last_updated)];
        }
        /**
         * Check if model has updated_at column
         */
        if ($model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable(), 'updated_at')) {
            $last_updated = $model::max('updated_at');
            return ['last_updated' => GeneralHelper::db_date_format_timestamp_24_hours($last_updated)];
        }
    }

    /**
     * checks whether a model/table has specifed field/column in the table
     */
    public static function modelHasField($model, $field)
    {
        return $model->getConnection()
            ->getSchemaBuilder()
            ->hasColumn(@$model->getTable(), $field);
    }

    public static function save_model($model, $data)
    {
        // dd(class_basename($model));
        // dd($data);
        $updateIds = ActionHelper::UpdateIds();
        $modelName  = class_basename($model);
        //  dd($modelName);
        if (array_search($modelName, $updateIds) >= 0) {
            // dd($data[$updateIds[$modelName]]);
            // $record = $model::where($updateIds[$modelName], $data[$updateIds[$modelName]])->first();
            $record = $model::where([$updateIds[$modelName] => $data[$updateIds[$modelName]]])->first();
            // dd($record);
            $record = $record ? $record : new $model;
        } else {
            $record =  $model::find(@$data['id']) ?? new $model;
        }

        if (@$data['appraisal_deskquestion_id'] == 10) {
            // dd($data);
        }
        // dd($record);
        // dd(true);

        $table = class_basename($record);

        $unique_fields = @ActionHelper::ModelUniqueFields()[$table];
        if (@$unique_fields && @$data['id']) {
            foreach ($unique_fields as $field) {
                unset($data[$field]);
            }
        }
        // dd($unique_fields);
        // dd($data);
        $checkbox_fields = ActionHelper::CheckBoxBooleanFields();

        if (@$checkbox_fields[$table]) {
            foreach ($checkbox_fields[$table] as $checkboxField) {
                if (ModelHelper::modelHasField($record, $checkboxField)) {
                    $record->$checkboxField = @$data[$checkboxField] ?? 0;
                }
            }
        }

        foreach ($data as $field => $value) {
            if ($field == "id") continue;
            if (ModelHelper::modelHasField($record, $field)) {
                $record->{$field} = $value;
            }

            if (in_array($field, ActionHelper::ArrayAutoDates())) {
                $record->{$field} = now();
            }

            if (in_array($field, ActionHelper::ArrayTimeStampFields())) {
                $record->{$field} = GeneralHelper::db_date_format($value);
            }

            if (in_array($field, ActionHelper::ArrayNumericFields())) {
                $record->{$field} = (int) str_replace(',', '', $value);
            }
        }


        /**
         *  check if user is logged in 
         *  and make them creaters of this record
         */
        if (@auth()->user() && ModelHelper::modelHasField($record, 'updated_by')) {
            $record->updated_by = @auth()->id();
        }

        // dd($record);


        $record->save();
        //  dd($record);
        return $record;
    }


    /**
     * pending deskreview approvals
     */
    public static function PendingDistrictAppraisals($district_id = null)
    {
        $results = ViewPwdGroupApplication::whereNull('review_recommendation_id');
        if (!auth()->user()->is_admin && @$district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }

    public static function ApplicationGroupColumns()
    {
        return ['application_id', 'group_name', 'project_industry', 'implementation_period', 'pwd_grp_a_registration_id', 'district', 'total_cost', 'financial_contribution', 'borrowed', 'ds_appraisal_decision_id', 'dsg_recieved', 'created_at', 'ds_appraisal_financial_year', 'ds_appraisal_quarter'];
    }

    /**
     * pending desk review assignments
     */
    public static function PendingDeskReviewAssignments($desk_review = true, $assignee = null, $district_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            if ($desk_review) {
                $results = ViewApplicationDeskReview::whereNotNull('application_id');
            } else {
                $results = ViewApplicationDeskAssignment::whereNotNull('application_id');
            }
        } else {
            $results = ViewPwdGroupApplication::where('ds_appraisal_decision_id', 3);
        }


        if ($district_id) {
            $results = $results->where('district_id', $district_id);
        }

        if (!USE_APPRAISAL_NEW_PROCESS) {
            if ($desk_review) {
                $results->whereNull('deskreview_assign_to');
            }
        }

        if ($assignee) {
            if (USE_APPRAISAL_NEW_PROCESS) {
                $results->where('deskreview_assign_to', $assignee->id);
                // $results->where('deskreview_assign_to', $assignee->id)->where(function ($query) {
                //     // $query->where('deskdecision_id', 1)
                //     //     ->orwhere('deskdecision_id', 5)
                //     //     ->orwhere('deskdecision_id', 7);
                // });
            } else {
                $results->where('deskreview_assign_to', $assignee->id)->whereNull('deskdecision_id');
            }
        } else {
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results->orwhere('deskdecision_id', 1);
                // $results->orwhere('deskdecision_approved', 0);
            }
        }

        return $results;
    }

    /**
     * pending desk review approvals
     */
    public static function PendingDeskReviewApprovals($approve = true, $district_id = null)
    {
        $results = ViewApplicationDeskApproval::whereNotNull('application_id');

        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }

    /**
     * pending field review assignments
     */
    public static function PendingFieldReviewAssignments($field_review = true, $assignee = null, $district_id = null, $count = false)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            if ($field_review) {
                $results = ViewApplicationFieldReview::whereNotNull('application_id');
            } else {
                $results = ViewApplicationFieldAssignment::whereNotNull('application_id');
            }
        } else {
            $results = ViewPwdGroupApplication::where(['deskdecision_id' => 2, 'deskdecision_approved' => true]);
        }

        // dd($results->get());

        // dd($assignee);


        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        if ($assignee) {
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results = ViewPwdGroupApplication::where(['deskdecision_id' => 2, 'deskdecision_approved' => true]);
            }
            $results->when(USE_APPRAISAL_NEW_PROCESS, function ($query) use ($assignee) {
                $query->where('fieldreview_assign_to', $assignee->id);
            })->when(!USE_APPRAISAL_NEW_PROCESS, function ($query) use ($assignee) {
                $query->where('fieldreview_assign_to', $assignee->id)->whereNull('fielddecision_id');
            });
        } else {
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results->whereNull('fieldreview_assign_to');
            }
            // dd($results);
        }

        // $results->orwhere('fielddecision_approved', 0);
        // dd($field_review);
        if (@$field_review) {
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results->where(function ($query) {
                    $query->where('fielddecision_approved', false)
                        ->orwhere('fielddecision_approved', null);
                });
            }
        }

        if (!USE_APPRAISAL_NEW_PROCESS) {
            $results->orwhereNull('fieldreview_assign_to');
            $results->where('fielddecision_approved', false);
        }


        // dd($results->toSql());

        return $results;
    }

    /**
     * pending desk review approvals
     */
    public static function PendingFieldReviewApprovals($district_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationFieldReviewApproval::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::whereNotNull('fielddecision_id')->whereNull('fielddecision_approved');
        }
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }


    /**
     * pending funding review assignments
     */
    public static function PendingFundingReviewAssignments($funding_review = true, $assignee = null, $district_id = null, $count = false)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            if ($funding_review) {
                $results = ViewApplicationFundingReview::whereNotNull('application_id');
            } else {
                $results = ViewApplicationFundingAssignment::whereNotNull('application_id');
            }
        } else {
            $results = ViewPwdGroupApplication::where(['fundingddecision_id' => null, 'fielddecision_approved' => true]);
        }

        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        if ($assignee) {
            if (USE_APPRAISAL_NEW_PROCESS) {
                $results->where('assign_to', $assignee->id);
            } else {
                $results->where('funding_assign_to', $assignee->id)->whereNull('fundingddecision');
            }
        } else {
            if (USE_APPRAISAL_NEW_PROCESS) {
                if ($funding_review) {
                    $results->whereNull('assign_to');
                }
            } else {
                $results->whereNull('funding_assign_to');
            }
        }

        return $results;
    }

    /**
     * pending desk review approvals
     */
    public static function PendingFundingReviewApprovals($district_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationFundingApproval::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::whereNotNull('fundingddecision_id')->whereNull('fundingddecision_approved');
        }
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }

    /**
     * pending desk review approvals
     */
    public static function DisbursementQualifyingApplications($district_id = null, $assignee = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationDisbursementNsgAssign::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::where(['fundingddecision_id' => 2, 'fundingddecision_approved' => true]);
        }

        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        // dd($results->get());

        if ($assignee) {
            // dd(0);
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results->where('nsg_dis_assign_to', $assignee->id)->whereNull('nsg_dis_approved')->whereNull('is_selected');
            }
        } else {
            if (!USE_APPRAISAL_NEW_PROCESS) {
                $results->whereNull('nsg_dis_assign_to');
            }
        }

        return $results;
    }

    /**
     * pending desk review approvals
     */
    public static function DisbursementAssignments($assignee = null, $district_id = null)
    {
        if ($assignee) {
            $results = ViewApplicationDisbursementNationalSelection::whereNotNull('application_id');
            $results->where('disbursement_assign_to', $assignee->id);
        } else {
            $results = ViewApplicationDisbursementNsgAssign::whereNotNull('application_id');
        }

        // if ($assignee) {
        // }

        if ($district_id) {
            $results->where('district_id', $district_id);
        }
        return $results;
    }




    /**
     * pending desk review approvals
     */
    public static function NSGApprovals($district_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationDisbursementNationalRecommendation::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::where('is_selected', true)->whereNull('nsg_dis_approved');
        }
        // $results = ViewPwdGroupApplication::whereNull('nsg_dis_approved');
        if ($district_id) {
            $results->where('district_id', $district_id);
        }
        return $results;
    }


    /**
     * applications selected for funding
     */
    public static function ReceiptQualifyingApplications($district_id = null, $bank_id = null)
    {

        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationDisbursementNationalApproved::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::whereNull('nsg_dis_recieved')->where('nsg_dis_approved', true);
        }
        // $results = ViewPwdGroupApplication::whereNull('nsg_dis_recieved');
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        if (USE_APPRAISAL_NEW_PROCESS) {
            if ($bank_id) {
                $results->where('approved_account_bank_id', $bank_id);
            }
        } else {
            if ($bank_id) {
                $results->where('stp_bank_id', $bank_id);
            }
        }

        return $results;
    }

    /**
     * applications selected for funding
     */
    public static function QualifyingApplicationsList($district_id = null, $financial_year_id = null, $quarter_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationDisbursementNsgAssign::whereNotNull('application_id');
        } else {
            $results = ViewPwdGroupApplication::where('fundingddecision_id', 2)->where('fundingddecision_approved', true);
        }

        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        if ($financial_year_id) {
            $results->where('fundingddecision_financial_year_id', $financial_year_id);
        }

        if ($quarter_id) {
            $results->where('fundingddecision_quarter_id', $quarter_id);
        }

        return $results;
    }

    public static function DeskReviewReAssignments($district_id = null)
    {
        $results = ViewApplicationDeskReassignment::whereNotNull('application_id');
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }

    public static function FieldReviewReAssignments($district_id = null)
    {
        $results = ViewApplicationFieldReassignment::whereNotNull('application_id');
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }

    public static function FundingReviewReAssignments($district_id = null)
    {
        $results = ViewApplicationFundingReassignment::whereNotNull('application_id');
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        return $results;
    }


    public static function NSGDisbursementSelectionList($district_id = null, $financial_year_id = null, $quarter_id = null)
    {
        if (USE_APPRAISAL_NEW_PROCESS) {
            $results = ViewApplicationDisbursementNationalRecommendation::whereNotNull('application_id');
        } else {
            // $results = ViewPwdGroupApplication::where('fundingddecision_id', 2)->where('fundingddecision_approved', true);
            $results = ViewPwdGroupApplication::where('is_selected', true)->where('nsg_dis_approved', null);
        }
        if ($district_id) {
            $results->where('district_id', $district_id);
        }

        // if ($financial_year_id) {
        //     $results->where('fundingddecision_financial_year_id', $financial_year_id);
        // }

        // if ($quarter_id) {
        //     $results->where('fundingddecision_quarter_id', $quarter_id);
        // }

        return $results;
    }


    public static function ComplaintEscalationToId($record)
    {
        if (@$record->is_district_complaint()) {
            if (!@$record->escalation) {
                return User::getRoleId(RolePermission::ROLE_SUBCOUNTY_CDO);
            }

            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_COMMUNITY_DEVELOPER_OFFICER)
            ) {
                return User::getRoleId(RolePermission::ROLE_SUBCOUNTY_CDO);
            }

            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_SUBCOUNTY_CDO)
            ) {
                return User::getRoleId(RolePermission::ROLE_DISTRICT_CDO);
            }

            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_DISTRICT_CDO)
            ) {
                return User::getRoleId(RolePermission::ROLE_DISTRICT_ACCOUNTING_OFFICER);
            }
        } else {
            if (!@$record->escalation) {
                return User::getRoleId(RolePermission::ROLE_PROGRAM_OFFICER);
            }

            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_ASSISTANT_PROGRAM_OFFICER)
            ) {
                return User::getRoleId(RolePermission::ROLE_PROGRAM_OFFICER);
            }


            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_PROGRAM_OFFICER)
            ) {
                return User::getRoleId(RolePermission::ROLE_NATIONAL_PROGRAM_COORDINATOR);
            }

            if (
                @$record->escalation->escalated_to_role_id == User::getRoleId(RolePermission::ROLE_NATIONAL_PROGRAM_COORDINATOR)
            ) {
                return User::getRoleId(RolePermission::ROLE_ASSISTANT_COMMISSIONER);
            }
        }
    }

    public static function ComplaintIsEscalated($user, $record)
    {
        if (@!$record->is_escalated_to_role_id) {
            return false;
        }

        if (@$user->role_id == @$record->is_escalated_to_role_id) {
            return true;
        }
        return false;
    }
}
