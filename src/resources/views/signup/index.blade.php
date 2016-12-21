@extends('projectsquare-payment::master')

@section('page-title')
    {{ trans('projectsquare-payment::pages.seo_title_signup') }}
@endsection

@section('main-content')
    <form action="{{ route('signup_handler') }}" method="post" class="template signup_template">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="fil-ariane">
                    <li>
                        <a href="http://projectsquare.io/">{{ trans('projectsquare-payment::pages.home_title') }}</a>
                    </li>
                    <li class="page_fille">
                        {{ trans('projectsquare-payment::signup.title') }}
                    </li>
                </ul>

                <h1 class="title background_blue">{{ trans('projectsquare-payment::signup.title') }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 stepwizard">

                <div class="stepwizard-step active-step col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <p>1.<br/>{{ trans('projectsquare-payment::signup.step1_title') }}</p>
                    <span data-tab="1" class="img-step img-platform"></span>
                </div>
                <div class="stepwizard-step col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <p>2.<br/>{{ trans('projectsquare-payment::signup.step2_title') }}</p>
                    <span data-tab="2" class="img-step img-coordonnees"></span>
                </div>
                <div class="stepwizard-step col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <p>3.<br/>{{ trans('projectsquare-payment::signup.step3_title') }}</p>
                    <span data-tab="3" class="img-step img-valid"></span>
                </div>
            </div>
        </div>

        <div class="row">
            @if (isset($error) && $error)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ $error }}
                </div>
            @endif

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="background_blue signup-wrapper">
                    <div class="setup-content" id="step-1">
                        @include('projectsquare-payment::signup.steps.step1')
                    </div>

                    <div class="setup-content" id="step-2">
                        @include('projectsquare-payment::signup.steps.step2')
                    </div>

                    <div class="setup-content" id="step-3">
                        @include('projectsquare-payment::signup.steps.step3')
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="platform_monthly_cost" value="{{ $platform_monthly_cost }}" />
        <input type="hidden" id="user_monthly_cost" value="{{ $user_monthly_cost }}" />
    </form>

    <script>var route_check_slug = "{{ route('signup_check_slug') }}";</script>
    <script src="{{ asset('js/signup.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.min.js"></script>

@endsection