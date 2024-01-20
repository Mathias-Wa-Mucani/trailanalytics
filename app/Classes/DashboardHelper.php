<?php

namespace App\Classes;

use App\Classes\GeneralHelper;
use App\Models\Disability;
use App\Models\PwdRegistration;
use App\Models\Views\ViewDashboard;

class DashboardHelper
{
    // public $dashboardFullView;
    // public function __construct(
    //     ViewDashboard $dashboardFullView
    // ) {
    //     $this->dashboardFullView = $dashboardFullView->first();
    // }
    public static $dashboardFullView;
    public function __construct()
    {
        self::$dashboardFullView = ViewDashboard::first();
    }

    // public static function DashboardFullView()
    // {
    //     return ViewDashboard::first();
    // }

    public static function generate_full_stats()
    {
        return self::$dashboardFullView;
    }

    public static function GeneralOverview()
    {
        return [
            'current_financial_year' => self::$dashboardFullView->current_financial_year,
            'num_pwd' => (int)self::$dashboardFullView->num_pwd,
            'num_pwd_current_fy' => (int)self::$dashboardFullView->num_pwd_current_fy,
            'num_groups' => (int)self::$dashboardFullView->num_groups,
            'num_groups_current_fy' => (int)self::$dashboardFullView->num_groups_current_fy,
            'cum_total_applic' => (int)self::$dashboardFullView->cum_total_applic,
            'cur_total_applic' => (int)self::$dashboardFullView->cur_total_applic,
            'cum_nsg_num_disbursements' => (int)self::$dashboardFullView->cum_nsg_num_disbursements,
            'cur_nsg_num_disbursements' => (int)self::$dashboardFullView->cur_nsg_num_disbursements,
        ];
    }

    public static function SexDisaggregation()
    {
        return [
            'males' => (int)self::$dashboardFullView->males,
            'females' => (int)self::$dashboardFullView->females,
            'num_group_males' => (int)self::$dashboardFullView->num_group_males,
            'num_group_females' => (int)self::$dashboardFullView->num_group_females,
            'num_group_males_leaders' => (int)self::$dashboardFullView->num_group_males_leaders,
            'num_group_females_leaders' => (int)self::$dashboardFullView->num_group_females_leaders,
        ];
    }


    public static function GroupDisaggregation()
    {
        return [
            'members' => self::$dashboardFullView->members,
            'avg_grp_per_district' => (float)self::$dashboardFullView->avg_grp_per_district,
            'avg_grp_members' => (float)self::$dashboardFullView->avg_grp_members,
        ];
    }

    public static function EducationDisaggregation()
    {
        return [
            'no_formal_education' => (int)self::$dashboardFullView->no_formal_education,
            'primary_not_completed' => (int)self::$dashboardFullView->primary_not_completed,
            'completed_primary' => (int)self::$dashboardFullView->completed_primary,
            'o_level_not_completed' => (int)self::$dashboardFullView->o_level_not_completed,
            'completed_o_level' => (int)self::$dashboardFullView->completed_o_level,
            'a_level_not_completed' => (int)self::$dashboardFullView->a_level_not_completed,
            'completed_a_level' => (int)self::$dashboardFullView->completed_a_level,
            'tertiary_institutions_not_completed' => (int)self::$dashboardFullView->tertiary_institutions_not_completed,
            'completed_tertiary_university_included' => (int)self::$dashboardFullView->completed_tertiary_university_included,
            'masters_degree_not_completed' => (int)self::$dashboardFullView->masters_degree_not_completed,
            'attained_masters_degree' => (int)self::$dashboardFullView->attained_masters_degree,
            'phd_not_completed' => (int)self::$dashboardFullView->phd_not_completed,
            'attained_phd' => (int)self::$dashboardFullView->attained_phd,
            'above_tertiary' => (int)self::$dashboardFullView->above_tertiary,
        ];
    }


    public static function NationalAppraisalApprovalStatistics()
    {
        return [
            'cur_deskreview_approved' => (int)self::$dashboardFullView->cur_deskreview_approved,
            'cum_deskreview_approved' => (int)self::$dashboardFullView->cum_deskreview_approved,
            'cur_fieldreview_approved' => (int)self::$dashboardFullView->cur_fieldreview_approved,
            'cum_fieldreview_approved' => (int)self::$dashboardFullView->cum_fieldreview_approved,
            'cur_fundingreview_approved' => (int)self::$dashboardFullView->cur_fundingreview_approved,
            'cum_fundingreview_approved' => (int)self::$dashboardFullView->cum_fundingreview_approved,
        ];
    }

    public static function DistrictAppraisalStatistics()
    {
        return [
            'cur_district_rejected' => self::$dashboardFullView->cur_district_rejected,
            'cum_district_rejected' => self::$dashboardFullView->cum_district_rejected,
            'cur_district_approved' => self::$dashboardFullView->cur_district_approved,
            'cum_district_approved' => self::$dashboardFullView->cum_district_approved,
            'cur_district_ngs_refered' => self::$dashboardFullView->cur_district_ngs_refered,
            'cum_district_ngs_refered' => self::$dashboardFullView->cum_district_ngs_refered,
            'cur_district_deffered' => self::$dashboardFullView->cur_district_deffered,
            'cum_district_deffered' => self::$dashboardFullView->cum_district_deffered,
        ];
    }

    public static function NSGDisbursements()
    {
        return [
            'cur_nsg_expected_sales' => (int)self::$dashboardFullView->cur_nsg_expected_sales,
            'cum_nsg_expected_sales' => (int)self::$dashboardFullView->cum_nsg_expected_sales,
            'cur_nsg_budget' => (int)self::$dashboardFullView->cur_nsg_budget,
            'cum_nsg_budget' => (int)self::$dashboardFullView->cum_nsg_budget,
            'cur_nsg_financial_contribution' => (int)self::$dashboardFullView->cur_nsg_financial_contribution,
            'cum_nsg_financial_contribution' => (int)self::$dashboardFullView->cum_nsg_financial_contribution,
            'cur_nsg_amount_requested' => (int)self::$dashboardFullView->cur_nsg_amount_requested,
            'cum_nsg_amount_requested' => (int)self::$dashboardFullView->cum_nsg_amount_requested,
        ];
    }


    public static function ApplicationStatistics()
    {
        return [
            'cur_total_applic' => (int)self::$dashboardFullView->cur_total_applic,
            'cum_total_applic' => (int)self::$dashboardFullView->cum_total_applic,
            'avg_cur_applic_budget' => (float)self::$dashboardFullView->avg_cur_applic_budget,
            'avg_cum_applic_budget' => (float)self::$dashboardFullView->avg_cum_applic_budget,
            'avg_cur_applic_sales' => (float)self::$dashboardFullView->avg_cur_applic_sales,
            'avg_cum_applic_sales' => (float)self::$dashboardFullView->avg_cum_applic_sales,
            'avg_cur_contribution' => (float)self::$dashboardFullView->avg_cur_contribution,
            'avg_cum_contribution' => (float)self::$dashboardFullView->avg_cum_contribution,
            'avg_cur_requested' => (float)self::$dashboardFullView->avg_cur_requested,
            'avg_cum_requested' => (float)self::$dashboardFullView->avg_cum_requested,
        ];
    }

    public static function disability_breakdown()
    {
        return array(
            'deaf' => (int)self::$dashboardFullView->deaf,
            'deaf_blind' => (int)self::$dashboardFullView->deaf_blind,
            'blindness' => (int)self::$dashboardFullView->blindness,
            'speech_and_voice' => (int)self::$dashboardFullView->speech_and_voice,
            'physical_disability' => (int)self::$dashboardFullView->physical_disability,
            'mental' => (int)self::$dashboardFullView->mental,
            'little_people' => (int)self::$dashboardFullView->little_people,
            'albinism' => (int)self::$dashboardFullView->albinism,
            'multiple_disabilities' => (int)self::$dashboardFullView->multiple_disabilities,
            'other_disability' => (int)self::$dashboardFullView->other_disability
        );
    }
}
