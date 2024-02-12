<?php

use App\Models\MainMenu;
use App\Models\SubMenu;

$mainmenus = MainMenu::all();
$submenus = SubMenu::all();

?>

<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0 " data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo py-8" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center">
            <img alt="Logo" src="{{ asset('public/assets/media/logos/trail_banner.png') }}" class="h-45px logo" />
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid" id="kt_aside_menu">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold"
                id="#kt_aside_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                @foreach ($mainmenus as $index => $main)
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                        class="menu-item herex {{ $index == 0 ? 'show' : '' }} py-2">
                        <!--begin:Menu link-->
                        <span class="menu-link menu-center">
                            <span class="menu-icon me-0 {{ $main->icons }} fa-lg">
                                <i class="ki-outline   fs-2x"></i>
                            </span>
                            <span class="menu-title">{{ $main->name }}</span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->

                        <div class="menu-sub menu-sub-dropdown px-2 py-4 w-250px mh-75 overflow-auto">
                            @foreach ($submenus as $index => $submenu)
                                @if ($main->id == $submenu->menu_id)
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link"
                                            href="<?= $submenu->route != '' ? route($submenu->route) : '' ?> ">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ $submenu->name }}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                @endif
                            @endforeach

                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endforeach


            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto" id="kt_aside_footer">
        <!--begin::Menu-->
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btm-sm btn-icon btn-custom btn-active-color-primary"
                data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Quick actions">
                <i class="ki-outline ki-notification-status fs-1"></i>
            </button>
            <!--begin::Menu 2-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mb-3 opacity-75"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Ticket</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Customer</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                    <!--begin::Menu item-->
                    <a href="#" class="menu-link px-3">
                        <span class="menu-title">New Group</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <!--end::Menu item-->
                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Admin Group</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Staff Group</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Member Group</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu sub-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Contact</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mt-3 opacity-75"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content px-3 py-3">
                        <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                    </div>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu 2-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Footer-->
</div>
