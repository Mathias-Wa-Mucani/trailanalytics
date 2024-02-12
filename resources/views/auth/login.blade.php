@extends('elements.master-layout')
@section('title')
    TrailAnalytics|Login
@endsection

{{-- start main content --}}
@section('content')
    {{-- <p>This is my body content.</p> --}}
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('{{ asset('public/assets/media/auth/bg4.jpg') }}');
            background-repeat: no-repeat;
            /* background-size: contain; */
            background-position: center;

        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ asset('public/assets/media/auth/bg4-dark.jpg') }}');
        }
    </style>
    <!--end::Page bg image-->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="javascript:;" class="mb-7">
                    <img alt="Logo" class="img-fluid" src="{{ asset('public/assets/media/logos/trail_banner.png') }}" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0 mx-auto">Trail Analytics</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                        data-kt-redirect-url="{{ route('dashboard')}}" action="{{ route('login') }}" method="POST">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            {{-- <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div> --}}
                            <!--end::Subtitle=-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Login options-->
                        <div class="row g-3 mb-9 d-none">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Google link=-->
                                <a href="#"
                                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo"
                                        src="{{ asset('public/assets/media/svg/brand-logos/google-icon.svg') }}"
                                        class="h-15px me-3" />Sign in with Google</a>
                                <!--end::Google link=-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Google link=-->
                                <a href="#"
                                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo"
                                        src="{{ asset('public/assets/media/svg/brand-logos/apple-black.svg') }}"
                                        class="theme-light-show h-15px me-3" />
                                    <img alt="Logo"
                                        src="{{ asset('public/assets/media/svg/brand-logos/apple-black-dark.svg') }}"
                                        class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
                                <!--end::Google link=-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Login options-->
                        <!--begin::Separator-->
                        <div class="separator separator-content my-14 d-none">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                        </div>
                        <!--end::Separator-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            {{-- <input type="text" placeholder="Email" name="email" autocomplete="on"
                                class="form-control bg-transparent" /> --}}

                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

                            <input id="email" type="email" placeholder="Email"
                                class="form-control bg-transparent @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-3">
                            <!--begin::Password-->
                            {{-- <input type="password" placeholder="Password" name="password" autocomplete="on"
                                class="form-control bg-transparent" /> --}}

                            <input id="password" type="password" placeholder="Password"
                                class="form-control bg-transparent @error('password') is-invalid @enderror" name="password"
                                required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <!--end::Password-->
                        </div>
                        
                        <!--end::Input group=-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div>
                                <input classx="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <!--begin::Link-->
                            <a href="authentication/layouts/creative/reset-password.html" class="link-primary">Forgot
                                Password ?</a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="button" id="kt_sign_in_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Sign In</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                        <!--begin::Sign up-->
                        <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                            <a href="authentication/layouts/creative/sign-up.html" class="link-primary">Sign up</a>
                        </div>
                        <!--end::Sign up-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Footer-->
                <div class="d-flex flex-stack px-lg-10">
                    <!--begin::Languages-->
                    <div class="me-0 d-none">
                        <!--begin::Toggle-->
                        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                            data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3"
                                src="{{ asset('public/assets/media/flags/united-states.svg') }}" alt="" />
                            <span data-kt-element="current-lang-name" class="me-1">English</span>
                            <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
                        </button>
                        <!--end::Toggle-->
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7"
                            data-kt-menu="true" id="kt_auth_lang_menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('public/assets/media/flags/united-states.svg') }}"
                                            alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">English</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('public/assets/media/flags/spain.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Spanish</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('public/assets/media/flags/germany.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">German</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('public/assets/media/flags/japan.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Japanese</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1"
                                            src="{{ asset('public/assets/media/flags/france.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">French</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Languages-->
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5 d-none">
                        @include('elements/footer')
                        {{-- <a href="pages/team.html" target="_blank">Terms</a>
                        <a href="pages/pricing/column.html" target="_blank">Plans</a>
                        <a href="pages/contact.html" target="_blank">Contact Us</a> --}}
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
@endsection
{{-- end main content --}}
@section('custom-js')
    @include('scripts.public.login')
    <script>
        // alert('hello custom');
    </script>
@endsection
