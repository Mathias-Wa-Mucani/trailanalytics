<?php

namespace App\Classes;

class MenuHelper
{
    public static function main_menu()
    {
        return [
            /**
             * Dashboard 
             */
            "dashboard" => array(
                "show" =>  true,
                "title" => "Dashboard",
                "page_title" => "Dashboard",
                "route" => "dashboard",
                "icon" => "fa fa-tachometer",
            ),



            /**
             * Registration
             */
            "registration" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::PWD_REGISTRATION_FEATURES),
                "title" => "Registration",
                "page_title" => "PWD Registration",
                "icon" => "fa fa-user",
                // "route" => "module.fys",
                // "route_params" => ["registration"],
                "route" => "module_list",
                "route_params" => ["registration"],
            ),

            /**
             * Groups
             */
            "groups" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::PWD_GROUPS_FEATURES),
                "title" => "Groups",
                "page_title" => "PWD Groups",
                "icon" => "fa fa-users",
                "route" => "module_list",
                "route_params" => ["groups"],
            ),

            /**
             * Applications
             */
            "applications" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::GROUP_APPLICATION_FEATURES),
                "title" => "Applications",
                "page_title" => "Special Grants Group Applications",
                "icon" => "fa fa-desktop",
                // "route" => "module.fys",
                // "route_params" => ["applications"],
                "route" => "module_list",
                "route_params" => ["applications"],
            ),

            /**
             * complaints and grievances
             */
            "complaints_and_grievances" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::COMPLAINTS_AND_GRIEVANCIES),
                "title" => "Complaints & Grievances",
                "page_title" => "Complaints & Grievances",
                "icon" => "fa fa-tags",
                "sub_menu" => array(
                    // array("title" => "Current Reports", "route" => "reports.section", "route_params" => ["pwd-district-statistics"]),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::COMPLAINTS_AND_GRIEVANCIES_DISTRICT),
                        "title" => "District Complaints & Grievances",
                        "route" => "complaints.section",
                        "route_params" => ["district"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::COMPLAINTS_AND_GRIEVANCIES_NSG),
                        "title" => "NSG Complaints & Grievances",
                        "route" => "complaints.section",
                        "route_params" => ["nsg"]
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::COMPLAINTS_AND_GRIEVANCIES_DISTRICT),
                        "title" => "District C&G Archive",
                        "route" => "complaints.section",
                        "route_params" => ["district-achive"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::COMPLAINTS_AND_GRIEVANCIES_NSG),
                        "title" => "National  C&G Archive",
                        "route" => "complaints.section",
                        "route_params" => ["national-achive"]
                    ),

                )
            ),


            /**
             * Grants
             */
            // "grants" => array(
            //     "show" => true,
            //     "title" => "Grants",
            //     "page_title" => "Grants",
            //     "icon" => "fa fa-credit-card",
            // ),

            /**
             * Assignments
             */
            "district_appraisals" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL),
                "title" => "District Appraisal",
                "page_title" => "District Appraisal",
                "icon" => "fa fa-coffee",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_REVIEW),
                        "title" => "District Appraisal Review",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["appraisal-review"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_MAKE_DECISION),
                        "title" => "Make Decision",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["make-decision"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_CAPTURE_DISBURSEMENTS),
                        "title" => "Capture Disbursements",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["capture-disbursements"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_REJECTED_APPLICATIONS),
                        "title" => "Reverse District Decisions",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["reverse-district-decisions"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_RETURNED_APPLICATIONS),
                        "title" => "Returned Applications",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["returned-applications"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISTRICT_APPRAISAL_REVERSE_DISTRICT_DECISION),
                        "title" => "Rejected Applications",
                        "route" => "appraisals_menu.district",
                        "route_params" => ["reverse-district-decisions"],
                        "route_params" => ["rejected-applications"],
                    ),
                )
            ),

            /**
             * Appraisals
             */

            "appraisals" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENTS),
                "title" => "Assign",
                "page_title" => "Assignments",
                "icon" => "fa fa-share",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_DESK),
                        "title" => "Assign Desk Reviewers",
                        "route" => "appraisals_menu.national",
                        "route_params" => ["desk-assessment"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_FIELD),
                        "title" => "Assign Field Reviewers",
                        "route" => "appraisals_menu.national",
                        "route_params" => ["field-verification"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_FUNDING),
                        "title" => "Assign Fund Reviewers",
                        "route" => "appraisals_menu.national",
                        "route_params" => ["funding-review"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_REASSIGNMENT_DESK) || auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_REASSIGNMENT_FIELD) || auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_REASSIGNMENT_FUNDING),
                        "title" => "Re-Assign",
                        "route" => null,
                        "sub_menu" => array(
                            array(
                                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_DESK),
                                "title" => "Desk Re-assignment",
                                "route" => "reassignment.section",
                                "route_params" => ["desk-assessment"],
                            ),
                            array(
                                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_FIELD),
                                "title" => "Field Re-assignment",
                                "route" => "reassignment.section",
                                "route_params" => ["field-verification"],
                            ),
                            array(
                                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_ASSIGNMENT_FUNDING),
                                "title" => "Fund Re-assignment",
                                "route" => "reassignment.section",
                                "route_params" => ["funding-review"],
                            ),
                        )
                    )
                )
            ),

            /**
             * Assignments
             */
            "assignments" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISALS),
                "title" => "Appraisals",
                "page_title" => "Appraisals",
                "icon" => "fa fa-coffee",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_DESK),
                        "title" => "Desk Appraisal",
                        "route" => "assignment.section",
                        "route_params" => ["desk-assessment"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_FIELD),
                        "title" => "Field Verification",
                        "route" => "assignment.section",
                        "route_params" => ["field-review"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_FUNDING),
                        "title" => "Funding Appraisal",
                        "route" => "assignment.section",
                        "route_params" => ["funding-review"]
                    ),
                    // array(
                    //     "show" => true,
                    //     "title" => "NSG Appraisal",
                    //     "route" => "assignment.section",
                    //     "route_params" => ["nsg"]
                    // ),
                )
            ),

            /**
             * Approvals
             */
            "approvals" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_APPROVALS),
                "title" => "Approvals",
                "page_title" => "Approvals",
                "icon" => "fa fa-coffee",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_APPROVAL_DESK),
                        "title" => "Desk Review Approvals",
                        "route" => "appraisals_menu.national.approvals",
                        "route_params" => ["desk-review"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_APPROVAL_FIELD),
                        "title" => "Field Review Approvals",
                        "route" => "appraisals_menu.national.approvals",
                        "route_params" => ["field-review"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::APPRAISAL_APPROVAL_FUNDING),
                        "title" => "Funding Review Approvals",
                        "route" => "appraisals_menu.national.approvals",
                        "route_params" => ["funding-review"],
                    ),
                    // array(
                    //     "show" => auth()->user()->IsCommissioner(),
                    //     "title" => "NSG Approvals",
                    //     "route" => "appraisals_menu.national.approvals",
                    //     "route_params" => ["nsg"],
                    // )
                )
            ),

            /**
             * Disbursements
             */
            "disbursements" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS),
                "title" => "Disbursements",
                "page_title" => "Disbursements",
                "icon" => "fa fa-money",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_LIST_OF_QUALIFYING_APPLICATIONS),
                        "title" => "List of Qualifying Applications",
                        "route" => "disbursements.section",
                        "route_params" => ["qualifying-applications"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_ASSIGN_SELECTIONS_FOR_NSG_SELECTION),
                        "title" => "Assign Selectors for Final NSG Selection",
                        "route" => "disbursements.section",
                        "route_params" => ["sign-selectors-qualifying-applications"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_NSG_SELECTION),
                        "title" => "NSG Selection",
                        "route" => "disbursements.section",
                        "route_params" => ["nsg-disbursement-selection"],

                        // "route" => "assignment.section",
                        // "route_params" => ["nsg"]
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_NSG_SELECTION_LIST),
                        "title" => "NSG Recommendation List",
                        "route" => "disbursements.section",
                        "route_params" => ["nsg-disbursement-selection-list"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_NSG_APPROVAL),
                        "title" => "NSG Approval",
                        "route" => "disbursements.section",
                        "route_params" => ["nsg-approvals"],
                        // "route" => "appraisals_menu.national.approvals",
                        // "route_params" => ["nsg"],
                    ),

                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_NSG_DISBURSEMENT_LIST),
                        "title" => "NSG Disbursement List",
                        "route" => "disbursements.section",
                        "route_params" => ["nsg-disbursement-list"]
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::DISBURSEMENTS_CONFIRMATION_OF_RECEIPT),
                        "title" => "Disbursement Confirmation of Receipt",
                        "route" => "disbursements.section",
                        "route_params" => ["disbursement-confirmation-receipt"]
                    )
                )
            ),


            /**
             * Distrtic Committee   
             */
            // "district_committee" => array(
            //     "show" =>
            //     auth()->user()->IsDistrictCDO(),
            //     "title" => "District Committee",
            //     "page_title" => "District Committe",
            //     "icon" => "fa fa-users",
            //     "route" => "module_list",
            //     "route_params" => ["district-committee"],
            // ),

            "reports" => array(
                // "show" =>  auth()->user()->hasPermissionTo(RolePermission::REPORTS),
                "show" =>  true,
                "title" => "Reports",
                "page_title" => "Reports",
                "icon" => "fa fa-bar-chart-o",
                "sub_menu" => array(
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::REPORTS_STATISTICAL_REPORTS),
                        "title" => "Statistic Reports",
                        "route" => "statistic_reports",
                        // "route_params" => ["realtime", "district-reports"],
                    ),
                    array(
                        "show" =>  auth()->user()->hasPermissionTo(RolePermission::REPORTS_GRAPH_REPORTS),
                        "title" => "Graph Reports",
                        "route" => "graph_reports",
                        // "route_params" => ["realtime", "district-reports"],
                    ),

                    array(
                        "show" =>  true,
                        "title" => "Basic Reports",
                        "route" => "basic_reports",
                        // "route_params" => ["realtime", "district-reports"],
                    ),
                )
            ),


            /**
             * Settings
             */
            "settings" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::SETTINGS),
                "title" => "Settings",
                "page_title" => "Settings",
                "route" => "settings",
                "icon" => "fa fa fa-cog",
            ),

            /**
             * User Management
             */
            "user_management" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::USER_MANAGEMENT),
                "title" => "User Management",
                "page_title" => "User Management",
                "route" => "user_management_section",
                "route_params" => "system-users",
                "icon" => "fa fa fa-user",
            ),

            /**
             * Public Area
             */
            "public_area" => array(
                "show" =>  auth()->user()->hasPermissionTo(RolePermission::PUBLIC_AREA),
                "title" => "Public Area",
                "page_title" => "Public Area",
                "icon" => "fa fa-globe",
                "route" => "public_area"
            ),

        ];
    }

    public static function settings_menu()
    {
        return [
            "general" => array(
                "show" => true,
                "title" => "General",
                "sub_menu" => array(
                    array(
                        "show" => true,
                        'title' => 'Financial Years',
                        'section' => 'financial-years',
                    ),
                    array(
                        "show" => true,
                        'title' => 'Banks',
                        'section' => 'banks',
                    ),
                    array(
                        "show" => true,
                        'title' => 'Positions',
                        'section' => 'positions',
                    ),
                    array(
                        "show" => true,
                        'title' => 'Statuses',
                        'section' => 'statuses',
                    ),
                    array(
                        'show' => auth()->user()->is_admin,
                        'title' => 'Unit Measures',
                        'section' => 'unit-measures',
                    ),
                    array(
                        'show' => auth()->user()->is_admin,
                        'title' => 'Group Roles',
                        'section' => 'group-roles',
                    ),
                    array(
                        'title' => 'Committee Roles',
                        'section' => 'committee-roles',
                        'show' => auth()->user()->is_admin
                    ),
                    array(
                        "show" => true,
                        // 'show' => auth()->user()->hasPermissionTo(RolePermission::MANAGE_BUSINESS_CATEGORIES)
                        'title' => 'Project Industries',
                        'section' => 'project-industries',
                    ),
                    array(
                        // "show" => true,
                        'show' => auth()->user()->is_admin,
                        'title' => 'Delete Reasons',
                        'section' => 'delete-reasons',
                    ),
                    array(
                        // "show" => true,
                        'show' => auth()->user()->is_admin,
                        'title' => 'Publication Categories',
                        'section' => 'publication-categories',
                    ),

                    array(
                        'show' => auth()->user()->is_admin,
                        'title' => 'FAQs Categories',
                        'section' => 'faqs-categories',
                    ),
                )
            ),

            "regions" => array(
                "show" => auth()->user()->is_admin,
                "title" => "Regions",
                "sub_menu" => array(
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Districts',
                        'section' => 'districts',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Counties',
                        'section' => 'counties',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Subcounties',
                        'section' => 'subcounties',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Parishes',
                        'section' => 'parishes',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Villages',
                        'section' => 'villages',
                    ),
                )
            ),

            PWDS_TAG => array(
                "show" => auth()->user()->is_admin,
                "title" => "PWDs",
                "sub_menu" => array(
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Disabilities',
                        'section' => 'disabilities',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Disability Severities',
                        'section' => 'disability-severities',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Disability Causes',
                        'section' => 'disability-causes',
                    ),

                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'PWD Services',
                        'section' => 'pwd-services',
                    ),

                    // array(
                    //     "show" => auth()->user()->is_admin,
                    //     'title' => 'PWD Services Received',
                    //     'section' => 'pwd-services-received',
                    // ),
                    // array(
                    //     "show" => auth()->user()->is_admin,
                    //     // 'show' => auth()->user()->hasPermissionTo(RolePermission::MANAGE_SUPPORT_REQUIRED_LIST)
                    //     'title' => 'PWD Support Required',
                    //     'section' => 'pwd-support-required',
                    // ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Educational Levels',
                        'section' => 'educational-levels',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Educational Certificates',
                        'section' => 'educational-certificates',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Complaints and Grievances Categories',
                        'section' => 'complaint-categories',
                    ),
                )
            ),

            'appraisals' => array(
                "show" => auth()->user()->is_admin,
                "title" => "Appraisals",
                "sub_menu" => array(
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'District Appraisal Decisions',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Desk Questions',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Desk Decisions',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'Field Decisions',
                    ),
                    array(
                        "show" => auth()->user()->is_admin,
                        'title' => 'National Appraisal Decisions',
                    )
                )
            ),

            // "system" => array(
            //     "show" => auth()->user()->is_admin,
            //     "title" => "System Settings",
            //     "sub_menu" => array(
            //         // array('title' => 'System Roles'),
            //         array(
            //             "show" => auth()->user()->is_admin,
            //             'title' => 'Terms of Use',
            //         ),
            //     )
            // ),

        ];
    }

    public static function userManagementMenu()
    {
        return array(
            "system-users" => array(
                "title" => "System Users",
                "route" => "user_management",
            ),
            "system-roles" => array(
                "title" => "User Groups & Permissions",
                "route" => "user_management",
            ),
            "audit-trail" => array(
                "title" => "Audit Trail",
                "route" => "user_management",
            )
        );
    }

    public static function PublicAreaMenu()
    {
        return array(
            "publications" => array(
                "title" => "Publications",
                "route" => "public_area",
            ),
            "faqs" => array(
                "title" => "Faqs",
                "route" => "public_area",
            ),
            "terms-of-use" => array(
                "title" => "Terms of Use",
                "route" => "public_area",
            ),
            "privacy-policy" => array(
                "title" => "Privacy Policy",
                "route" => "public_area",
            ),
            "system-settings" => array(
                "title" => "System Settings",
                "route" => "public_area",
            )
        );
    }
}
